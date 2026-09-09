import logging
import os
import re

from telegram import Update
from telegram.constants import ChatType, ParseMode
from telegram.ext import (
    Application,
    CommandHandler,
    ContextTypes,
    MessageHandler,
    filters,
)

logging.basicConfig(
    format="%(asctime)s - %(name)s - %(levelname)s - %(message)s",
    level=logging.INFO,
)
logger = logging.getLogger(__name__)

GROUP_CHAT_TYPES = (ChatType.GROUP, ChatType.SUPERGROUP)

# In-memory tracking: chat_id -> user_id -> (display_name, username).
# Resets if the bot restarts or redeploys.
tracked_identities: dict[int, dict[int, tuple[str, str | None]]] = {}

# Single global destination chat for change notifications, set via /setlog.
# If unset, notifications are posted in the same group where the change
# was seen (like SangMata).
log_chat_id: int | None = None


def _escape_markdown(text: str) -> str:
    return re.sub(r"([_*`\[])", r"\\\1", text)


def _current_identity(user) -> tuple[str, str | None]:
    name = user.first_name or ""
    if user.last_name:
        name = f"{name} {user.last_name}".strip()
    return name, user.username


async def start(update: Update, context: ContextTypes.DEFAULT_TYPE) -> None:
    await update.message.reply_text(
        "👁 ¡Hola! Vigilo cambios de nombre y de @usuario en los grupos donde "
        "me añadas.\n\n"
        "1️⃣ Añádeme a los grupos que quieras vigilar.\n"
        "2️⃣ (Opcional) Añádeme también a un grupo de avisos y escribe /setlog "
        "ahí dentro — así todos los cambios se notifican en ese grupo en vez "
        "de en el grupo original.\n\n"
        "Solo detecto cambios de gente que escribe algo después de que me "
        "hayas añadido; no puedo ver un historial previo a eso."
    )


async def setlog(update: Update, context: ContextTypes.DEFAULT_TYPE) -> None:
    global log_chat_id

    if not update.effective_chat or update.effective_chat.type not in GROUP_CHAT_TYPES:
        await update.message.reply_text("Este comando es para usarlo dentro de un grupo.")
        return

    log_chat_id = update.effective_chat.id
    await update.message.reply_text(
        "✅ A partir de ahora mandaré aquí todos los avisos de cambios de "
        "nombre/usuario que detecte en los grupos donde esté."
    )


async def track_member(update: Update, context: ContextTypes.DEFAULT_TYPE) -> None:
    chat = update.effective_chat
    user = update.effective_user

    if not chat or chat.type not in GROUP_CHAT_TYPES or not user or user.is_bot:
        return

    current_name, current_username = _current_identity(user)
    chat_identities = tracked_identities.setdefault(chat.id, {})
    previous = chat_identities.get(user.id)
    chat_identities[user.id] = (current_name, current_username)

    if previous is None:
        return

    previous_name, previous_username = previous
    changes = []

    if previous_name != current_name:
        changes.append(
            f"📝 Nombre: *{_escape_markdown(previous_name)}* → "
            f"*{_escape_markdown(current_name)}*"
        )

    if previous_username != current_username:
        old_display = f"@{previous_username}" if previous_username else "_(sin usuario)_"
        new_display = f"@{current_username}" if current_username else "_(sin usuario)_"
        changes.append(f"🔗 Usuario: {old_display} → {new_display}")

    if not changes:
        return

    chat_title = _escape_markdown(chat.title or "este grupo")
    text = f"🔄 Cambio detectado en *{chat_title}*\n" + "\n".join(changes)

    destination = log_chat_id or chat.id
    await context.bot.send_message(
        chat_id=destination, text=text, parse_mode=ParseMode.MARKDOWN
    )


def main() -> None:
    token = os.environ.get("TELEGRAM_BOT_TOKEN")
    if not token:
        raise SystemExit(
            "Falta la variable de entorno TELEGRAM_BOT_TOKEN con el token del bot."
        )

    application = Application.builder().token(token).build()

    application.add_handler(CommandHandler("start", start))
    application.add_handler(CommandHandler("setlog", setlog))
    application.add_handler(
        MessageHandler(filters.ChatType.GROUPS & ~filters.COMMAND, track_member)
    )

    logger.info("Bot iniciado. Esperando mensajes...")
    application.run_polling(allowed_updates=Update.ALL_TYPES)


if __name__ == "__main__":
    main()
