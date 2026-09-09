import asyncio
import logging
import os
import random

from telegram import Update
from telegram.constants import ParseMode
from telegram.ext import Application, CommandHandler, ContextTypes

logging.basicConfig(
    format="%(asctime)s - %(name)s - %(levelname)s - %(message)s",
    level=logging.INFO,
)
logger = logging.getLogger(__name__)

DEFAULT_NUMBERS = [5, 10, 15, 20]
SPIN_FRAMES = ["🎰 Girando la ruleta.", "🎰 Girando la ruleta..", "🎰 Girando la ruleta..."]
SPIN_DELAY_SECONDS = 0.5


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

    if len(numbers) < 2:
        await update.message.reply_text(
            "⚠️ Dame al menos dos números para poder girar la ruleta. Ejemplo:\n/ruleta 5 10 15 20"
        )
        return

    message = await update.message.reply_text(SPIN_FRAMES[0])

    for frame in SPIN_FRAMES[1:]:
        await asyncio.sleep(SPIN_DELAY_SECONDS)
        await message.edit_text(frame)

    await asyncio.sleep(SPIN_DELAY_SECONDS)
    result = random.choice(numbers)
    await message.edit_text(
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
