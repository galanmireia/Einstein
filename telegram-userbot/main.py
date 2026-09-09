"""Anti-delete userbot: caches incoming messages and reports deletions.

Runs logged in as the account itself (via TELEGRAM_SESSION), so it sees
every message that arrives and Telegram's own deletion notifications for
messages it has already seen — neither of which a normal bot can access.

For each incoming message it remembers the sender and text. When Telegram
reports that message as deleted, it checks whether the account had
already read it (comparing against the last known read position for that
chat) and sends itself ("Saved Messages") a report either way.

Private chats and small basic groups don't include a chat id on deletion
events (Telegram limitation), only the message id, which is unique across
that space for the account. Channels and supergroups do include their
chat id, and have their own independent id space, so those are cached
separately.
"""

import asyncio
import logging
import os
from collections import OrderedDict

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

client = TelegramClient(StringSession(SESSION), API_ID, API_HASH)

# Private chats / basic groups: keyed by message id alone (Telegram gives
# no chat id on their deletion events, but ids are unique in that space).
private_cache: "OrderedDict[int, dict]" = OrderedDict()
# Channels / supergroups: keyed by (chat_id, message_id), their own
# independent id space, and deletion events do include the chat id.
channel_cache: "OrderedDict[tuple[int, int], dict]" = OrderedDict()

# chat_id -> highest inbox message id known to be read.
read_state: dict[int, int] = {}


def _cache_put(cache: "OrderedDict", key, value) -> None:
    cache[key] = value
    if len(cache) > MAX_CACHE_ENTRIES:
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
        for part in [getattr(sender, "first_name", None), getattr(sender, "last_name", None)]
        if part
    )
    return name or "Alguien"


@client.on(events.NewMessage(incoming=True))
async def on_new_message(event) -> None:
    entry = {
        "text": event.raw_text or "(mensaje sin texto: foto/vídeo/audio/etc.)",
        "sender_name": await _sender_display_name(event),
        "chat_title": getattr(event.chat, "title", None) if event.chat else None,
    }

    if event.is_channel:
        _cache_put(channel_cache, (event.chat_id, event.id), entry)
    else:
        _cache_put(private_cache, event.id, entry)


@client.on(events.MessageRead)
async def on_read(event) -> None:
    if event.inbox:
        read_state[event.chat_id] = max(read_state.get(event.chat_id, 0), event.max_id)


async def _report_deletion(entry: dict, msg_id: int, chat_id: int | None) -> None:
    was_read = msg_id <= read_state.get(chat_id, 0) if chat_id is not None else False
    status = "✅ Ya lo habías leído" if was_read else "🔴 NO lo habías leído"

    lines = [
        "🗑 *Mensaje borrado*",
        status,
        f"👤 De: {entry['sender_name']}",
    ]
    if entry.get("chat_title"):
        lines.append(f"💬 En: {entry['chat_title']}")
    lines.append(f"📝 \"{entry['text']}\"")

    await client.send_message("me", "\n".join(lines), parse_mode="markdown")


@client.on(events.MessageDeleted)
async def on_deleted(event) -> None:
    for msg_id in event.deleted_ids:
        if event.chat_id is not None:
            entry = channel_cache.pop((event.chat_id, msg_id), None)
            chat_id = event.chat_id
        else:
            entry = private_cache.pop(msg_id, None)
            chat_id = None

        if entry is None:
            continue

        await _report_deletion(entry, msg_id, chat_id)


async def _init_read_state() -> None:
    async for dialog in client.iter_dialogs():
        read_state[dialog.id] = dialog.dialog.read_inbox_max_id


async def main() -> None:
    await client.start()
    await _init_read_state()

    me = await client.get_me()
    logger.info("Userbot anti-borrado activo como %s (@%s)", me.first_name, me.username)

    await client.run_until_disconnected()


if __name__ == "__main__":
    asyncio.run(main())
