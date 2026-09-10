"""Roulette game logic for the userbot's ".ruleta" command.

Mirrors telegram-roulette-bot/bot.py's spin/payment/respin-chain rules,
but drives Telethon directly instead of python-telegram-bot: it sends
the spin video and follow-up messages into whatever chat the command
was typed in, using the account's own identity.
"""

import asyncio
import os
import random
from dataclasses import dataclass
from io import BytesIO

from telethon.tl.functions.messages import GetStickerSetRequest
from telethon.tl.types import DocumentAttributeVideo, InputStickerSetShortName

from roulette_wheel import build_spin_video

MIN_OPTIONS = 2
MAX_OPTIONS = 10
MAX_RESPINS = 5

# Optional: comma-separated short names of Telegram sticker sets (the
# part after t.me/addstickers/) to send one random sticker from
# alongside each result. Empty (the default) means no sticker is sent.
STICKER_PACK_NAMES = [
    name.strip()
    for name in os.environ.get("STICKER_PACK_NAME", "").split(",")
    if name.strip()
]
_sticker_documents: list | None = None


async def _get_random_sticker(client):
    global _sticker_documents

    if not STICKER_PACK_NAMES:
        return None

    if _sticker_documents is None:
        documents = []
        for pack_name in STICKER_PACK_NAMES:
            try:
                result = await client(
                    GetStickerSetRequest(
                        stickerset=InputStickerSetShortName(short_name=pack_name),
                        hash=0,
                    )
                )
                documents.extend(result.documents)
            except Exception:
                pass
        _sticker_documents = documents

    if not _sticker_documents:
        return None

    return random.choice(_sticker_documents)


@dataclass
class Segment:
    wheel_label: str
    reveal_text: str = ""
    kind: str = "number"  # "number" | "bonus" | "prize"
    value: int = 0
    payment: bool = False


FUNNY_PAYMENT_LINES = [
    "🎉 ¡Enhorabuena! Te has ganado el privilegio de enviar *{v}€* 👏",
    "👑 Qué honor el tuyo, te toca demostrar tu valía con *{v}€*",
    "🏆 ¡Lo conseguiste! Tu premio es la oportunidad de pagar *{v}€*",
    "🙌 Bien hecho, ahora demuestra que te lo mereces mandando *{v}€*",
    "😏 Mira qué suerte la tuya... te toca ganarte tu sitio con *{v}€*",
    "✨ Justo lo que necesitabas: la ocasión perfecta de enviar *{v}€*",
]


def _payment_message(value: int, respin: bool) -> str:
    text = random.choice(FUNNY_PAYMENT_LINES).format(v=value)
    if respin:
        text += " 🔁 Y de premio, ¡vuelves a girar!"
    return text


def _make_segments(values: list[int], respin_values: list[int]) -> list[Segment]:
    segments = [Segment(f"+{v}", kind="number", value=v, payment=True) for v in values]
    segments += [
        Segment(f"+{v}\nTIRA\nOTRA VEZ", kind="bonus", value=v, payment=True)
        for v in respin_values
    ]
    segments.append(
        Segment(
            "PREMIO",
            "🏆🦶 ¡Premio especial! Tienes que mandar una foto de tus pies 😂",
            kind="prize",
            value=0,
        )
    )
    return segments


EASY_SEGMENTS = _make_segments(values=[5, 10, 15, 20], respin_values=[5, 10])
MEDIUM_SEGMENTS = _make_segments(values=[10, 20, 30, 40], respin_values=[10, 20, 30])
HARD_SEGMENTS = _make_segments(values=[20, 40, 60, 80], respin_values=[20, 40, 60, 80])

DIFFICULTIES = {
    "e": ("Easy", EASY_SEGMENTS),
    "m": ("Medium", MEDIUM_SEGMENTS),
    "h": ("Hard", HARD_SEGMENTS),
}

DEFAULT_SEGMENTS = EASY_SEGMENTS


async def _spin_once(client, chat_id, segments: list[Segment]) -> Segment:
    winning_index = random.randrange(len(segments))
    winner = segments[winning_index]
    wheel_labels = [segment.wheel_label for segment in segments]

    loop = asyncio.get_running_loop()
    video_bytes, total_duration_ms, width, height, thumbnail_bytes = (
        await loop.run_in_executor(None, build_spin_video, wheel_labels, winning_index)
    )

    video_file = BytesIO(video_bytes)
    video_file.name = "ruleta.mp4"
    thumb_file = BytesIO(thumbnail_bytes)
    thumb_file.name = "thumb.png"

    await client.send_file(
        chat_id,
        file=video_file,
        thumb=thumb_file,
        attributes=[
            DocumentAttributeVideo(
                duration=round(total_duration_ms / 1000),
                w=width,
                h=height,
                supports_streaming=True,
            )
        ],
        caption="🎰 ¡Girando la ruleta!",
    )

    await asyncio.sleep(total_duration_ms / 1000)

    if winner.payment:
        text = _payment_message(winner.value, respin=winner.kind == "bonus")
    else:
        text = winner.reveal_text

    if text:
        await client.send_message(chat_id, text, parse_mode="markdown")

    sticker = await _get_random_sticker(client)
    if sticker is not None:
        await client.send_file(chat_id, sticker)

    return winner


async def run_roulette(client, chat_id, requested_difficulty: str | None) -> None:
    if requested_difficulty in DIFFICULTIES:
        difficulty_name, segments = DIFFICULTIES[requested_difficulty]
        await client.send_message(
            chat_id, f"🎚 Dificultad: *{difficulty_name}*", parse_mode="markdown"
        )
    else:
        segments = DEFAULT_SEGMENTS

    total = 0
    history: list[str] = []
    is_payment = False

    for _ in range(MAX_RESPINS):
        winner = await _spin_once(client, chat_id, segments)

        if winner.kind == "prize":
            return

        total += winner.value
        history.append(winner.wheel_label.replace("\n", " "))
        is_payment = is_payment or winner.payment

        if winner.kind == "number":
            break
    else:
        await client.send_message(chat_id, "🎰 ¡Vale ya, que te quedas sin girar más! 😅")
        return

    if len(history) > 1:
        breakdown = " + ".join(history)
        label = "Total a pagar" if is_payment else "Total acumulado"
        suffix = "€" if is_payment else ""
        await client.send_message(
            chat_id,
            f"🧮 {label} ({breakdown}) = *{total}{suffix}*",
            parse_mode="markdown",
        )
