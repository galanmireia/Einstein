import asyncio
import io
import logging
import os
import random

from telegram import InputFile, Update
from telegram.constants import ParseMode
from telegram.ext import Application, CommandHandler, ContextTypes

from roulette_wheel import build_spin_video

logging.basicConfig(
    format="%(asctime)s - %(name)s - %(levelname)s - %(message)s",
    level=logging.INFO,
)
logger = logging.getLogger(__name__)

DEFAULT_NUMBERS = [5, 10, 15, 20]
MIN_NUMBERS = 2
MAX_NUMBERS = 10


async def start(update: Update, context: ContextTypes.DEFAULT_TYPE) -> None:
    await update.message.reply_text(
        "¡Hola! Soy la ruleta 🎰\n\n"
        "Usa /ruleta para girar y obtener un número al azar entre "
        f"{', '.join(str(n) for n in DEFAULT_NUMBERS)}.\n\n"
        "También puedes darme tus propios números, por ejemplo:\n"
        "/ruleta 5 10 15 20 25"
    )


def parse_numbers(args: list[str]) -> list[int] | None:
    if not args:
        return DEFAULT_NUMBERS

    numbers = []
    for arg in args:
        try:
            numbers.append(int(arg))
        except ValueError:
            return None
    return numbers


async def ruleta(update: Update, context: ContextTypes.DEFAULT_TYPE) -> None:
    numbers = parse_numbers(context.args)

    if numbers is None:
        await update.message.reply_text(
            "⚠️ Solo puedo girar con números enteros. Ejemplo:\n/ruleta 5 10 15 20"
        )
        return

    if len(numbers) < MIN_NUMBERS:
        await update.message.reply_text(
            "⚠️ Dame al menos dos números para poder girar la ruleta. Ejemplo:\n/ruleta 5 10 15 20"
        )
        return

    if len(numbers) > MAX_NUMBERS:
        await update.message.reply_text(
            f"⚠️ Como mucho {MAX_NUMBERS} números para que la ruleta se vea bien 🙂"
        )
        return

    winning_index = random.randrange(len(numbers))
    result = numbers[winning_index]

    loop = asyncio.get_running_loop()
    video_bytes, total_duration_ms, width, height = await loop.run_in_executor(
        None, build_spin_video, numbers, winning_index
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

    await update.message.reply_text(
        f"🎉 ¡La ruleta se detuvo en *{result}*!",
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
