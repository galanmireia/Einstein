import asyncio
import logging
import os
import re
from collections import OrderedDict
from dataclasses import dataclass
from datetime import datetime, timezone
from io import BytesIO

from deep_translator import GoogleTranslator
from telethon import TelegramClient, events
from telethon.sessions import StringSession

from roulette import DIFFICULTIES, run_roulette

logging.basicConfig(
    format="%(asctime)s - %(name)s - %(levelname)s - %(message)s",
    level=logging.INFO,
)
logger = logging.getLogger(__name__)

API_ID = int(os.environ["TELEGRAM_API_ID"])
API_HASH = os.environ["TELEGRAM_API_HASH"]
SESSION = os.environ["TELEGRAM_SESSION"]

MAX_CACHE_ENTRIES = 5000
MAX_MEDIA_CACHE_ENTRIES = 150
MAX_MEDIA_BYTES = 15 * 1024 * 1024

client = TelegramClient(StringSession(SESSION), API_ID, API_HASH)

# Mensajes privados / grupos básicos
private_cache: "OrderedDict[int, dict]" = OrderedDict()

# Canales / supergrupos
channel_cache: "OrderedDict[tuple[int, int], dict]" = OrderedDict()

# Multimedia utilizada por el sistema de mensajes borrados
media_cache: "OrderedDict[object, dict]" = OrderedDict()

# chat_id -> último mensaje leído
read_state: dict[int, int] = {}


@dataclass
class HistoryEntry:
    name: str
    username: str | None
    seen_at: str


# Solo se rellena para quien haya escrito en algún chat que esta cuenta
# haya visto (privado o grupo). Se reinicia si el proceso se reinicia.
identity_history: dict[int, list[HistoryEntry]] = {}

# Notas manuales guardadas con ".historial n <texto>", por user_id.
identity_notes: dict[int, str] = {}


def _current_identity(user) -> tuple[str, str | None]:
    name = user.first_name or ""
    if user.last_name:
        name = f"{name} {user.last_name}".strip()
    return name or "Alguien", user.username


async def _observe_identity(user) -> None:
    if user is None or getattr(user, "bot", False):
        return

    current_name, current_username = _current_identity(user)
    history = identity_history.setdefault(user.id, [])
    previous = history[-1] if history else None

    if previous is not None and previous.name == current_name and previous.username == current_username:
        return

    now = datetime.now(timezone.utc).strftime("%Y-%m-%d %H:%M UTC")
    history.append(HistoryEntry(current_name, current_username, now))


def _cache_put(cache: "OrderedDict", key, value, max_entries: int) -> None:
    cache[key] = value
    cache.move_to_end(key)

    if len(cache) > max_entries:
        cache.popitem(last=False)


async def _sender_display_name(event) -> str:
    sender = await event.get_sender()

    if sender is None:
        return "Alguien"

    username = getattr(sender, "username", None)

    if username:
        return f"@{username}"

    name = " ".join(
        part
        for part in [
            getattr(sender, "first_name", None),
            getattr(sender, "last_name", None),
        ]
        if part
    )

    return name or "Alguien"


async def _download_media(event, key) -> dict | None:
    file_info = event.file

    if file_info is None or (
        file_info.size and file_info.size > MAX_MEDIA_BYTES
    ):
        return None

    try:
        data = await event.download_media(file=bytes)
    except Exception:
        logger.exception(
            "No se pudo descargar el archivo del mensaje"
        )
        return None

    if not data:
        return None

    send_kwargs = {}

    if event.voice:
        send_kwargs["voice_note"] = True
        filename = "voice.ogg"

    elif event.video_note:
        send_kwargs["video_note"] = True
        filename = "video_note.mp4"

    elif event.photo:
        filename = "photo.jpg"

    elif event.video:
        filename = file_info.name or "video.mp4"

    elif event.audio:
        filename = file_info.name or "audio.mp3"

    else:
        filename = file_info.name or f"file{file_info.ext or ''}"

    media = {
        "data": data,
        "filename": filename,
        "send_kwargs": send_kwargs,
    }

    _cache_put(
        media_cache,
        key,
        media,
        MAX_MEDIA_CACHE_ENTRIES,
    )

    return media


async def _forward_media_to_alerts(key, media) -> None:
    """
    Reenvía la media (foto, vídeo, nota de voz, etc.) a Mensajes guardados
    en cuanto llega, solo para los chats activados con .unir. Telegram no
    entrega de forma fiable a esta sesión el aviso de "ya lo has leído"
    para chats privados, así que en vez de esperar a eso, se reenvía
    directamente al recibirla.
    """

    try:
        file_obj = BytesIO(media["data"])
        file_obj.name = media.get("filename") or "archivo"

        await client.send_file(
            "me",
            file_obj,
            **media["send_kwargs"],
        )

    except Exception:
        logger.exception(
            "No se pudo enviar automáticamente la media: %s",
            key,
        )


ROULETTE_COMMAND_RE = re.compile(r"^\.ruleta(?:\s+(\w+))?\s*$", re.IGNORECASE)
UNIR_COMMAND_RE = re.compile(r"^\.unir\s*$", re.IGNORECASE)

# Por defecto, además del reporte de borrados (siempre activo en todos
# lados), los chats privados también reenvían cada foto/vídeo a Mensajes
# guardados en cuanto llega; los grupos/canales no. .unir invierte ese
# valor por defecto para el chat donde se escriba, quedando guardado
# aquí como excepción explícita.
media_forwarding_overrides: dict[int, bool] = {}


def _media_forwarding_enabled(event) -> bool:
    if event.chat_id in media_forwarding_overrides:
        return media_forwarding_overrides[event.chat_id]
    return bool(event.is_private)


@client.on(events.NewMessage(outgoing=True, pattern=ROULETTE_COMMAND_RE))
async def on_ruleta_command(event) -> None:
    difficulty_arg = (event.pattern_match.group(1) or "").lower()
    requested_difficulty = difficulty_arg if difficulty_arg in DIFFICULTIES else None

    await event.delete()

    try:
        await run_roulette(client, event.chat_id, requested_difficulty)
    except Exception:
        logger.exception("Error al girar la ruleta")
        await client.send_message(event.chat_id, "⚠️ Algo falló girando la ruleta.")


@client.on(events.NewMessage(outgoing=True, pattern=UNIR_COMMAND_RE))
async def on_unir_command(event) -> None:
    chat_id = event.chat_id
    currently_enabled = _media_forwarding_enabled(event)
    chat = await event.get_chat()
    chat_name = getattr(chat, "title", None) or getattr(chat, "first_name", None) or "este chat"

    await event.delete()

    media_forwarding_overrides[chat_id] = not currently_enabled

    if not currently_enabled:
        await client.send_message(
            "me", f"🔔 Guardado automático de fotos/vídeos activado en: {chat_name}"
        )
    else:
        await client.send_message(
            "me", f"🔕 Guardado automático de fotos/vídeos desactivado en: {chat_name}"
        )


HISTORIAL_COMMAND_RE = re.compile(r"^\.historial(?:\s+n\s+(.+))?\s*$", re.IGNORECASE | re.DOTALL)


@client.on(events.NewMessage(outgoing=True, pattern=HISTORIAL_COMMAND_RE))
async def on_historial_command(event) -> None:
    note_text = event.pattern_match.group(1)
    await event.delete()

    if event.is_reply:
        reply_msg = await event.get_reply_message()
        if reply_msg is None or reply_msg.sender_id is None:
            await client.send_message("me", "⚠️ No he podido identificar a esa persona.")
            return
        user_id = reply_msg.sender_id
    elif event.is_private:
        # En un chat privado no hace falta responder: solo hay otra
        # persona posible, el propio chat.
        user_id = event.chat_id
    else:
        await client.send_message(
            "me", "⚠️ Usa .historial respondiendo al mensaje de esa persona."
        )
        return

    if note_text:
        identity_notes[user_id] = note_text.strip()
        await client.send_message(
            "me", f"🗒 Nota guardada para `{user_id}`.", parse_mode="markdown"
        )
        return

    history = identity_history.get(user_id)
    if not history:
        await client.send_message("me", "⚠️ Todavía no tengo historial de esa persona.")
        return

    current = history[-1]
    current_username = f"@{current.username}" if current.username else "(sin usuario)"

    lines = [
        f"🆔 ID: `{user_id}`",
        f"📛 Nombre actual: *{current.name}*",
        f"🔗 Usuario actual: {current_username}",
    ]

    note = identity_notes.get(user_id)
    if note:
        lines.append(f"🗒 Nota: {note}")

    lines.append("")
    lines.append("🕓 Historial:")
    for entry in history:
        entry_username = f"@{entry.username}" if entry.username else "(sin usuario)"
        lines.append(f"• {entry.seen_at} → {entry.name}, {entry_username}")

    await client.send_message("me", "\n".join(lines), parse_mode="markdown")


TRANSLATE_COMMAND_RE = re.compile(r"^\.t\s+(.+)$", re.IGNORECASE | re.DOTALL)

# Código corto -> idioma destino (clave en TRANSLATE_LANGUAGES). "" (sin
# código) usa DEFAULT_TRANSLATE_LANG. Se irán añadiendo más según haga
# falta.
TRANSLATE_LANG_CODES = {
    "v": "eu",  # vasco / euskara
}
DEFAULT_TRANSLATE_LANG = "en"

# Cada idioma necesita su código para Google (deep_translator normaliza
# estos) y, como reserva si Google falla (les cambia el HTML a veces),
# el código con locale que exige MyMemory.
TRANSLATE_LANGUAGES = {
    "en": {"google": "en", "mymemory": "en-GB"},
    "eu": {"google": "eu", "mymemory": "eu-ES"},
}
SOURCE_LANG_GOOGLE = "es"
SOURCE_LANG_MYMEMORY = "es-ES"


def _translate_sync(text: str, lang_key: str) -> str:
    codes = TRANSLATE_LANGUAGES[lang_key]

    try:
        return GoogleTranslator(source=SOURCE_LANG_GOOGLE, target=codes["google"]).translate(text)
    except Exception:
        logger.exception("Google Translate falló, probando con MyMemory")

    from deep_translator import MyMemoryTranslator

    return MyMemoryTranslator(source=SOURCE_LANG_MYMEMORY, target=codes["mymemory"]).translate(text)


@client.on(events.NewMessage(outgoing=True, pattern=TRANSLATE_COMMAND_RE))
async def on_translate_command(event) -> None:
    raw = event.pattern_match.group(1)
    parts = raw.split(maxsplit=1)

    if len(parts) == 2 and parts[0].lower() in TRANSLATE_LANG_CODES:
        lang_key = TRANSLATE_LANG_CODES[parts[0].lower()]
        text = parts[1]
    else:
        lang_key = DEFAULT_TRANSLATE_LANG
        text = raw

    await event.delete()

    try:
        loop = asyncio.get_running_loop()
        translated = await loop.run_in_executor(None, _translate_sync, text, lang_key)
    except Exception:
        logger.exception("Error al traducir")
        await client.send_message("me", f"⚠️ No se pudo traducir: {text[:200]}")
        return

    await client.send_message(event.chat_id, translated)


@client.on(events.NewMessage(incoming=True))
async def on_new_message(event) -> None:

    await _observe_identity(await event.get_sender())

    entry = {
        "text": event.raw_text or (
            "(sin texto)" if event.media else ""
        ),
        "sender_name": await _sender_display_name(event),
        "chat_title": (
            getattr(event.chat, "title", None)
            if event.chat
            else None
        ),
        "has_media": bool(event.media),
    }

    key = (
        (event.chat_id, event.id)
        if event.is_channel
        else event.id
    )

    cache = (
        channel_cache
        if event.is_channel
        else private_cache
    )

    _cache_put(
        cache,
        key,
        entry,
        MAX_CACHE_ENTRIES,
    )

    if event.media:
        media = await _download_media(event, key)
        if media is not None and _media_forwarding_enabled(event):
            await _forward_media_to_alerts(key, media)


@client.on(events.MessageRead)
async def on_read(event) -> None:
    if not event.inbox:
        return

    read_state[event.chat_id] = max(
        read_state.get(event.chat_id, 0),
        event.max_id,
    )


async def _report_deletion(
    entry: dict,
    media: dict | None,
    msg_id: int,
    chat_id: int | None,
) -> None:

    was_read = (
        msg_id <= read_state.get(chat_id, 0)
        if chat_id is not None
        else False
    )

    status = (
        "✅ Ya lo habías leído"
        if was_read
        else "🔴 NO lo habías leído"
    )

    lines = [
        "🗑 *Mensaje borrado*",
        status,
        f"👤 De: {entry['sender_name']}",
    ]

    if entry.get("chat_title"):
        lines.append(
            f"💬 En: {entry['chat_title']}"
        )

    if entry["text"]:
        lines.append(
            f"📝 \"{entry['text']}\""
        )

    if entry.get("has_media") and media is None:
        lines.append(
            "⚠️ Llevaba un archivo adjunto que no se pudo "
            "guardar (demasiado grande)."
        )

    caption = "\n".join(lines)

    if media is not None:

        file_obj = BytesIO(media["data"])
        file_obj.name = (
            media.get("filename")
            or "archivo"
        )

        await client.send_file(
            "me",
            file_obj,
            caption=caption,
            parse_mode="markdown",
            **media["send_kwargs"],
        )

    else:

        await client.send_message(
            "me",
            caption,
            parse_mode="markdown",
        )


@client.on(events.MessageDeleted)
async def on_deleted(event) -> None:

    for msg_id in event.deleted_ids:

        if event.chat_id is not None:

            key = (
                event.chat_id,
                msg_id,
            )

            entry = channel_cache.pop(
                key,
                None,
            )

            chat_id = event.chat_id

        else:

            key = msg_id

            entry = private_cache.pop(
                key,
                None,
            )

            chat_id = None

        if entry is None:
            continue

        media = media_cache.pop(
            key,
            None,
        )

        await _report_deletion(
            entry,
            media,
            msg_id,
            chat_id,
        )


async def _init_read_state() -> None:

    async for dialog in client.iter_dialogs():

        read_state[dialog.id] = (
            dialog.dialog.read_inbox_max_id
        )


async def main() -> None:

    await client.start()

    await _init_read_state()

    me = await client.get_me()

    logger.info(
        "Userbot anti-borrado activo como %s (@%s)",
        me.first_name,
        me.username,
    )

    await client.run_until_disconnected()


if __name__ == "__main__":
    asyncio.run(main())
