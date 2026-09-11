import logging
import os
import re
from dataclasses import dataclass
from datetime import datetime, timezone

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


@dataclass
class HistoryEntry:
    name: str
    username: str | None
    seen_at: str


# Only ever populated for people the bot has actually seen post in a group
# it's in. Resets if the bot restarts or redeploys. No lookup is possible
# for anyone the bot hasn't observed this way.
identity_history: dict[int, list[HistoryEntry]] = {}

# Every username ever seen for a user_id maps here (lowercase), so /whois
# still finds someone even by a username they've since changed away from.
username_index: dict[str, int] = {}

# Single global destination chat for change notifications, set via /setlog.
# If unset, notifications are posted in the same group where the change
# was seen (like SangMata).
log_chat_id: int | None = None


@dataclass
class Note:
    author: str
    text: str
    seen_at: str


# Notas compartidas entre todos los admins: cualquiera puede añadir o ver
# las de los demás, construyendo un histórico común por persona.
notes: dict[int, list[Note]] = {}


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
        "de en el grupo original.\n"
        "3️⃣ Usa /whois @usuario para ver el ID y el historial que tengo "
        "guardado de alguien.\n"
        "4️⃣ Usa /nota (respondiendo a su mensaje) para dejar una nota sobre "
        "alguien — la ven todos los admins con /whois, y entre todos vais "
        "construyendo un histórico común.\n\n"
        "Solo puedo ver a gente que ha escrito algo en un grupo donde estoy "
        "añadido — no tengo datos de nadie más."
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


GROUP_ANONYMOUS_BOT_ID = 1087968824


async def _is_group_admin(update: Update, context: ContextTypes.DEFAULT_TYPE) -> bool:
    # Messages sent as "anonymous admin" arrive from Telegram's special
    # GroupAnonymousBot account instead of the real user, so get_chat_member
    # on that id would fail even though only real admins can send that way.
    if update.effective_user.id == GROUP_ANONYMOUS_BOT_ID:
        return True

    member = await context.bot.get_chat_member(
        update.effective_chat.id, update.effective_user.id
    )
    return member.status in ("administrator", "creator")


async def whois(update: Update, context: ContextTypes.DEFAULT_TYPE) -> None:
    if not update.effective_chat or update.effective_chat.type not in GROUP_CHAT_TYPES:
        await update.message.reply_text("Este comando es para usarlo dentro de un grupo.")
        return

    if not await _is_group_admin(update, context):
        await update.message.reply_text(
            "⚠️ Solo los administradores del grupo pueden usar /whois."
        )
        return

    if not context.args:
        await update.message.reply_text("Uso: /whois @usuario")
        return

    query = context.args[0].lstrip("@").lower()
    user_id = username_index.get(query)

    if user_id is None or user_id not in identity_history:
        await update.message.reply_text(
            "⚠️ No tengo datos de ese usuario. Solo conozco a quien ha "
            "escrito en un grupo donde estoy añadido."
        )
        return

    history = identity_history[user_id]
    current = history[-1]
    current_username = f"@{current.username}" if current.username else "_(sin usuario)_"

    lines = [
        f"🆔 ID: `{user_id}`",
        f"📛 Nombre actual: *{_escape_markdown(current.name)}*",
        f"🔗 Usuario actual: {current_username}",
        "",
        "🕓 Historial:",
    ]
    for entry in history:
        entry_username = f"@{entry.username}" if entry.username else "(sin usuario)"
        lines.append(
            f"• {entry.seen_at} → {_escape_markdown(entry.name)}, {entry_username}"
        )

    user_notes = notes.get(user_id)
    if user_notes:
        lines.append("")
        lines.append("🗒 Notas:")
        for note in user_notes:
            lines.append(
                f"• {note.seen_at} ({_escape_markdown(note.author)}): "
                f"{_escape_markdown(note.text)}"
            )

    await update.message.reply_text("\n".join(lines), parse_mode=ParseMode.MARKDOWN)


async def nota(update: Update, context: ContextTypes.DEFAULT_TYPE) -> None:
    if not update.effective_chat or update.effective_chat.type not in GROUP_CHAT_TYPES:
        await update.message.reply_text("Este comando es para usarlo dentro de un grupo.")
        return

    if not await _is_group_admin(update, context):
        await update.message.reply_text(
            "⚠️ Solo los administradores del grupo pueden usar /nota."
        )
        return

    if not update.message.reply_to_message:
        await update.message.reply_text(
            "Usa /nota respondiendo al mensaje de la persona, seguido del texto. "
            "Ejemplo: /nota paga bien y rápido"
        )
        return

    if not context.args:
        await update.message.reply_text("Escribe algo después de /nota.")
        return

    target = update.message.reply_to_message.from_user
    if target is None or target.is_bot:
        await update.message.reply_text("⚠️ No puedo identificar a esa persona.")
        return

    author = update.effective_user.first_name or "Alguien"
    if update.effective_user.username:
        author = f"@{update.effective_user.username}"

    now = datetime.now(timezone.utc).strftime("%Y-%m-%d %H:%M UTC")
    note_text = " ".join(context.args)

    notes.setdefault(target.id, []).append(Note(author, note_text, now))

    await update.message.reply_text(
        f"✅ Nota guardada para {_escape_markdown(target.first_name or 'esa persona')}. "
        "Cualquier admin puede verla con /whois.",
        parse_mode=ParseMode.MARKDOWN,
    )


async def _observe_identity(context: ContextTypes.DEFAULT_TYPE, chat, user) -> None:
    if user.is_bot:
        return

    current_name, current_username = _current_identity(user)
    history = identity_history.setdefault(user.id, [])
    previous = history[-1] if history else None

    if current_username:
        username_index[current_username.lower()] = user.id

    if previous is not None and previous.name == current_name and previous.username == current_username:
        return

    now = datetime.now(timezone.utc).strftime("%Y-%m-%d %H:%M UTC")
    history.append(HistoryEntry(current_name, current_username, now))

    if previous is None:
        return

    changes = []

    if previous.name != current_name:
        changes.append(
            f"📝 Nombre: *{_escape_markdown(previous.name)}* → "
            f"*{_escape_markdown(current_name)}*"
        )

    if previous.username != current_username:
        old_display = f"@{previous.username}" if previous.username else "_(sin usuario)_"
        new_display = f"@{current_username}" if current_username else "_(sin usuario)_"
        changes.append(f"🔗 Usuario: {old_display} → {new_display}")

    chat_title = _escape_markdown(chat.title or "este grupo")
    text = f"🔄 Cambio detectado en *{chat_title}*\n" + "\n".join(changes)

    destination = log_chat_id or chat.id
    await context.bot.send_message(
        chat_id=destination, text=text, parse_mode=ParseMode.MARKDOWN
    )


async def track_member(update: Update, context: ContextTypes.DEFAULT_TYPE) -> None:
    chat = update.effective_chat
    user = update.effective_user

    if not chat or chat.type not in GROUP_CHAT_TYPES or not user:
        return

    await _observe_identity(context, chat, user)


async def track_new_members(update: Update, context: ContextTypes.DEFAULT_TYPE) -> None:
    chat = update.effective_chat
    new_members = update.message.new_chat_members if update.message else []

    if not chat or chat.type not in GROUP_CHAT_TYPES:
        return

    for member in new_members:
        await _observe_identity(context, chat, member)


def main() -> None:
    token = os.environ.get("TELEGRAM_BOT_TOKEN")
    if not token:
        raise SystemExit(
            "Falta la variable de entorno TELEGRAM_BOT_TOKEN con el token del bot."
        )

    application = Application.builder().token(token).build()

    application.add_handler(CommandHandler("start", start))
    application.add_handler(CommandHandler("setlog", setlog))
    application.add_handler(CommandHandler("whois", whois))
    application.add_handler(CommandHandler("nota", nota))
    application.add_handler(
        MessageHandler(
            filters.ChatType.GROUPS & filters.StatusUpdate.NEW_CHAT_MEMBERS,
            track_new_members,
        )
    )
    application.add_handler(
        MessageHandler(
            filters.ChatType.GROUPS
            & ~filters.COMMAND
            & ~filters.StatusUpdate.NEW_CHAT_MEMBERS,
            track_member,
        )
    )

    logger.info("Bot iniciado. Esperando mensajes...")
    application.run_polling(allowed_updates=Update.ALL_TYPES)


if __name__ == "__main__":
    main()
