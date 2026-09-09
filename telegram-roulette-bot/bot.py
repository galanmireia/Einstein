import asyncio
import io
import logging
import os
import random
import re
from dataclasses import dataclass

from telegram import InputFile, Update
from telegram.constants import ChatType, ParseMode
from telegram.ext import (
    Application,
    CommandHandler,
    ContextTypes,
    MessageHandler,
    filters,
)

from roulette_wheel import build_spin_video

logging.basicConfig(
    format="%(asctime)s - %(name)s - %(levelname)s - %(message)s",
    level=logging.INFO,
)
logger = logging.getLogger(__name__)

MIN_OPTIONS = 2
MAX_OPTIONS = 10
MAX_RESPINS = 5
WHEEL_NAME_MAX_LEN = 10

GROUP_CHAT_TYPES = (ChatType.GROUP, ChatType.SUPERGROUP)

# In-memory per-chat member registry: chat_id -> {user_id: display_name}.
# Telegram's Bot API has no method to list a group's full membership, so this
# only ever contains people the bot has actually seen post, plus anyone who
# has run /unirme. It resets if the bot restarts or redeploys.
chat_members: dict[int, dict[int, str]] = {}


@dataclass
class Segment:
    wheel_label: str
    reveal_text: str = ""
    kind: str = "number"  # "number" | "bonus" | "respin" | "prize"
    value: int = 0
    payment: bool = False


FUNNY_PAYMENT_LINES = [
    "😂 ¡Qué suertudo/a eres! Te toca pagar *{v}€*",
    "💸 Mala suerte... ¡pagas *{v}€*!",
    "🤑 Se te ve forrado/a, paga *{v}€*",
    "😅 Vaya papelón... pagas *{v}€*",
    "🙃 La ruleta no perdona: *{v}€* pa'l bote",
    "🥲 Hoy invitas tú: *{v}€*",
]


def _payment_message(value: int, respin: bool) -> str:
    text = random.choice(FUNNY_PAYMENT_LINES).format(v=value)
    if respin:
        text += " 🔁 Y encima vuelves a tirar..."
    return text


DEFAULT_SEGMENTS = [
    Segment("+5", kind="number", value=5, payment=True),
    Segment("+10", kind="number", value=10, payment=True),
    Segment("+15", kind="number", value=15, payment=True),
    Segment("+20", kind="number", value=20, payment=True),
    Segment("+5\nTIRA\nOTRA VEZ", kind="bonus", value=5, payment=True),
    Segment("+10\nTIRA\nOTRA VEZ", kind="bonus", value=10, payment=True),
    Segment(
        "PREMIO",
        "🏆🦶 ¡Premio especial! Tienes que mandar una foto de tus pies 😂",
        kind="prize",
        value=0,
    ),
]


def _display_name(user) -> str:
    if user.username:
        return f"@{user.username}"
    return user.first_name or "Alguien"


def _register_member(chat_id: int, user) -> None:
    chat_members.setdefault(chat_id, {})[user.id] = _display_name(user)


def _wheel_safe_label(name: str) -> str:
    if len(name) <= WHEEL_NAME_MAX_LEN:
        return name
    return name[: WHEEL_NAME_MAX_LEN - 1] + "…"


def _escape_markdown(text: str) -> str:
    return re.sub(r"([_*`\[])", r"\\\1", text)


async def track_member(update: Update, context: ContextTypes.DEFAULT_TYPE) -> None:
    if (
        update.effective_chat
        and update.effective_chat.type in GROUP_CHAT_TYPES
        and update.effective_user
        and not update.effective_user.is_bot
    ):
        _register_member(update.effective_chat.id, update.effective_user)


async def unirme(update: Update, context: ContextTypes.DEFAULT_TYPE) -> None:
    if not update.effective_chat or update.effective_chat.type not in GROUP_CHAT_TYPES:
        await update.message.reply_text("Este comando es para usarlo dentro de un grupo.")
        return

    _register_member(update.effective_chat.id, update.effective_user)
    count = len(chat_members.get(update.effective_chat.id, {}))
    await update.message.reply_text(
        f"✅ ¡Apuntado/a! Ahora hay {count} personas en la ruleta de este grupo."
    )


async def ruleta_gente(update: Update, context: ContextTypes.DEFAULT_TYPE) -> None:
    if not update.effective_chat or update.effective_chat.type not in GROUP_CHAT_TYPES:
        await update.message.reply_text("Este comando es para usarlo dentro de un grupo.")
        return

    members = chat_members.get(update.effective_chat.id, {})

    if len(members) < MIN_OPTIONS:
        await update.message.reply_text(
            "⚠️ Todavía no tengo suficientes nombres para esta ruleta.\n"
            "Telegram no deja a los bots ver la lista completa de miembros de "
            "un grupo, así que solo puedo apuntar a quien escribe algo aquí.\n"
            "Escribe cualquier mensaje en el grupo o usa /unirme para "
            "apuntarte, y pide a los demás que hagan lo mismo."
        )
        return

    names = list(members.values())
    if len(names) > MAX_OPTIONS:
        names = random.sample(names, MAX_OPTIONS)

    segments = [
        Segment(
            _wheel_safe_label(name),
            f"🎉 ¡Le toca a *{_escape_markdown(name)}*!",
            kind="number",
            value=0,
        )
        for name in names
    ]
    await spin_once(update, segments)


async def start(update: Update, context: ContextTypes.DEFAULT_TYPE) -> None:
    default_labels = ", ".join(
        segment.wheel_label.replace("\n", " ") for segment in DEFAULT_SEGMENTS
    )
    await update.message.reply_text(
        "¡Hola! Soy la ruleta 🎰\n\n"
        f"Usa /ruleta para girar la ruleta por defecto: {default_labels} (dinero a pagar 💸).\n"
        "Las casillas que ponen \"TIRA OTRA VEZ\" te hacen pagar Y además "
        "gira otra vez sola (puede encadenarse varias veces seguidas) hasta "
        "caer en una casilla normal, y entonces se suma todo lo que tienes "
        "que pagar.\n\n"
        "En un grupo también puedes usar /ruletagente para que elija al azar "
        "entre las personas que han escrito ahí o se han apuntado con "
        "/unirme (Telegram no deja a los bots ver la lista completa de "
        "miembros).\n\n"
        "También puedes darme tus propios números, por ejemplo:\n"
        "/ruleta 5 10 15 20 25"
    )


def parse_custom_segments(args: list[str]) -> list[Segment] | None:
    if not args:
        return None

    segments = []
    for arg in args:
        try:
            number = int(arg)
        except ValueError:
            return None
        segments.append(
            Segment(
                str(number),
                f"🎉 ¡La ruleta se detuvo en *{number}*!",
                kind="number",
                value=number,
            )
        )
    return segments


async def spin_once(update: Update, segments: list[Segment]) -> Segment:
    winning_index = random.randrange(len(segments))
    winner = segments[winning_index]
    wheel_labels = [segment.wheel_label for segment in segments]

    loop = asyncio.get_running_loop()
    video_bytes, total_duration_ms, width, height, _thumbnail_bytes = (
        await loop.run_in_executor(
            None, build_spin_video, wheel_labels, winning_index
        )
    )

    await update.message.reply_video(
        video=InputFile(io.BytesIO(video_bytes), filename="ruleta.mp4"),
        caption="🎰 ¡Girando la ruleta!",
        duration=round(total_duration_ms / 1000),
        width=width,
        height=height,
        supports_streaming=True,
    )

    await asyncio.sleep(total_duration_ms / 1000)

    if winner.payment:
        text = _payment_message(winner.value, respin=winner.kind == "bonus")
    else:
        text = winner.reveal_text
    await update.message.reply_text(text, parse_mode=ParseMode.MARKDOWN)

    return winner


async def ruleta(update: Update, context: ContextTypes.DEFAULT_TYPE) -> None:
    segments = parse_custom_segments(context.args)

    if segments is None and context.args:
        await update.message.reply_text(
            "⚠️ Solo puedo girar con números enteros. Ejemplo:\n/ruleta 5 10 15 20"
        )
        return

    if segments is None:
        segments = DEFAULT_SEGMENTS

    if len(segments) < MIN_OPTIONS:
        await update.message.reply_text(
            "⚠️ Dame al menos dos números para poder girar la ruleta. Ejemplo:\n/ruleta 5 10 15 20"
        )
        return

    if len(segments) > MAX_OPTIONS:
        await update.message.reply_text(
            f"⚠️ Como mucho {MAX_OPTIONS} números para que la ruleta se vea bien 🙂"
        )
        return

    total = 0
    history: list[str] = []
    is_payment = False

    for _ in range(MAX_RESPINS):
        winner = await spin_once(update, segments)

        if winner.kind == "prize":
            return

        total += winner.value
        history.append(winner.wheel_label.replace("\n", " "))
        is_payment = is_payment or winner.payment

        if winner.kind == "number":
            break
    else:
        await update.message.reply_text("🎰 ¡Vale ya, que te quedas sin girar más! 😅")
        return

    if len(history) > 1:
        breakdown = " + ".join(history)
        label = "Total a pagar" if is_payment else "Total acumulado"
        suffix = "€" if is_payment else ""
        await update.message.reply_text(
            f"🧮 {label} ({breakdown}) = *{total}{suffix}*",
            parse_mode=ParseMode.MARKDOWN,
        )


def main() -> None:
    token = os.environ.get("TELEGRAM_BOT_TOKEN")
    if not token:
        raise SystemExit(
            "Falta la variable de entorno TELEGRAM_BOT_TOKEN con el token del bot."
        )

    application = Application.builder().token(token).build()

    application.add_handler(CommandHandler("start", start))
    application.add_handler(CommandHandler("ruleta", ruleta))
    application.add_handler(CommandHandler("ruletagente", ruleta_gente))
    application.add_handler(CommandHandler("unirme", unirme))
    application.add_handler(
        MessageHandler(filters.ChatType.GROUPS & ~filters.COMMAND, track_member)
    )

    logger.info("Bot iniciado. Esperando comandos...")
    application.run_polling(allowed_updates=Update.ALL_TYPES)


if __name__ == "__main__":
    main()
