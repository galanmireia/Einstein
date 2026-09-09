import asyncio
import io
import logging
import os
import random
from dataclasses import dataclass

from telegram import InputFile, Update
from telegram.constants import ParseMode
from telegram.ext import Application, CommandHandler, ContextTypes

from roulette_wheel import build_spin_video

logging.basicConfig(
    format="%(asctime)s - %(name)s - %(levelname)s - %(message)s",
    level=logging.INFO,
)
logger = logging.getLogger(__name__)

MIN_OPTIONS = 2
MAX_OPTIONS = 10
MAX_RESPINS = 5


@dataclass
class Segment:
    wheel_label: str
    reveal_text: str
    kind: str = "number"  # "number" | "bonus" | "respin" | "prize"
    value: int = 0


DEFAULT_SEGMENTS = [
    Segment("+5", "🎉 ¡*+5* puntos!", kind="number", value=5),
    Segment("+10", "🎉 ¡*+10* puntos!", kind="number", value=10),
    Segment("+15", "🎉 ¡*+15* puntos!", kind="number", value=15),
    Segment("+20", "🎉 ¡*+20* puntos!", kind="number", value=20),
    Segment("+5*", "🎉 ¡*+5* puntos! 🔁 Y vuelve a tirar...", kind="bonus", value=5),
    Segment("+10*", "🎉 ¡*+10* puntos! 🔁 Y vuelve a tirar...", kind="bonus", value=10),
    Segment(
        "PREMIO",
        "🏆🦶 ¡Premio especial! Tienes que mandar una foto de tus pies 😂",
        kind="prize",
        value=0,
    ),
]


async def start(update: Update, context: ContextTypes.DEFAULT_TYPE) -> None:
    default_labels = ", ".join(segment.wheel_label for segment in DEFAULT_SEGMENTS)
    await update.message.reply_text(
        "¡Hola! Soy la ruleta 🎰\n\n"
        f"Usa /ruleta para girar la ruleta por defecto: {default_labels}.\n"
        "Las casillas con * suman puntos Y hacen que vuelva a girar sola "
        "(puede encadenarse varias veces) hasta caer en una casilla normal, "
        "y entonces se suman todos los puntos conseguidos.\n\n"
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

    await update.message.reply_text(winner.reveal_text, parse_mode=ParseMode.MARKDOWN)

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

    for _ in range(MAX_RESPINS):
        winner = await spin_once(update, segments)

        if winner.kind == "prize":
            return

        total += winner.value
        history.append(winner.wheel_label)

        if winner.kind == "number":
            break
    else:
        await update.message.reply_text("🎰 ¡Vale ya, que te quedas sin girar más! 😅")
        return

    if len(history) > 1:
        breakdown = " + ".join(history)
        await update.message.reply_text(
            f"🧮 Total acumulado ({breakdown}) = *{total}*",
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

    logger.info("Bot iniciado. Esperando comandos...")
    application.run_polling(allowed_updates=Update.ALL_TYPES)


if __name__ == "__main__":
    main()
