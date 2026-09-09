import asyncio
import logging
import os
from collections import OrderedDict
from io import BytesIO

from telethon import TelegramClient, events
from telethon.sessions import StringSession

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

# Claves de media ya reenviada al marcarse como leída, para no duplicarla
sent_on_read_keys: set = set()

# chat_id -> último mensaje leído
read_state: dict[int, int] = {}


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


async def _download_media(event, key) -> None:
    file_info = event.file

    if file_info is None or (
        file_info.size and file_info.size > MAX_MEDIA_BYTES
    ):
        return

    try:
        data = await event.download_media(file=bytes)
    except Exception:
        logger.exception(
            "No se pudo descargar el archivo del mensaje"
        )
        return

    if not data:
        return

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

    _cache_put(
        media_cache,
        key,
        {
            "data": data,
            "filename": filename,
            "send_kwargs": send_kwargs,
        },
        MAX_MEDIA_CACHE_ENTRIES,
    )


async def _send_media_to_alerts(key, media) -> None:
    """
    Reenvía la media (foto, vídeo, nota de voz, etc.) a Mensajes guardados
    en cuanto se lee, usando la copia ya descargada por _download_media.
    """

    if key in sent_on_read_keys:
        return

    try:
        file_obj = BytesIO(media["data"])
        file_obj.name = media.get("filename") or "archivo"

        await client.send_file(
            "me",
            file_obj,
            **media["send_kwargs"],
        )

        sent_on_read_keys.add(key)

        logger.info(
            "Media enviada automáticamente a Mensajes guardados: %s",
            key,
        )

    except Exception:
        logger.exception(
            "No se pudo enviar automáticamente la media: %s",
            key,
        )


@client.on(events.NewMessage(incoming=True))
async def on_new_message(event) -> None:

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
        await _download_media(event, key)


@client.on(events.MessageRead)
async def on_read(event) -> None:

    if not event.inbox:
        return

    chat_id = event.chat_id
    previous_max_id = read_state.get(chat_id, 0)
    new_max_id = event.max_id

    read_state[chat_id] = max(
        previous_max_id,
        new_max_id,
    )

    # Solo procesamos mensajes nuevos que han pasado
    # de no leídos a leídos.
    if new_max_id <= previous_max_id:
        return

    # Telegram puede marcar varios mensajes como leídos
    # simultáneamente, por lo que comprobamos el rango.
    for msg_id in range(
        previous_max_id + 1,
        new_max_id + 1,
    ):

        if event.is_channel:
            key = (chat_id, msg_id)
        else:
            key = msg_id

        media = media_cache.get(key)

        if media is None:
            continue

        await _send_media_to_alerts(
            key,
            media,
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
