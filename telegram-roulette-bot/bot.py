import asyncio
import io
import logging
import os
import random
import re
import time
import uuid
from dataclasses import dataclass

from aiohttp import web
from telegram import (
    InlineKeyboardButton,
    InlineKeyboardMarkup,
    InlineQueryResultVideo,
    InputFile,
    InputMediaVideo,
    Update,
)
from telegram.constants import ChatType, ParseMode
from telegram.ext import (
    Application,
    ChosenInlineResultHandler,
    CommandHandler,
    ContextTypes,
    InlineQueryHandler,
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

# Optional allowlist restricting who can spin the roulette. Set via the
# ALLOWED_USERS env var: a comma-separated list of usernames (with or
# without "@") and/or numeric user IDs, e.g. "mireia_g,123456789". Empty
# (the default) means anyone can use the bot.
_raw_allowed_users = os.environ.get("ALLOWED_USERS", "")
ALLOWED_USER_IDS = {
    int(item) for item in _raw_allowed_users.split(",") if item.strip().lstrip("-").isdigit()
}
ALLOWED_USERNAMES = {
    item.strip().lstrip("@").lower()
    for item in _raw_allowed_users.split(",")
    if item.strip() and not item.strip().lstrip("-").isdigit()
}


def _is_allowed(user) -> bool:
    if not ALLOWED_USER_IDS and not ALLOWED_USERNAMES:
        return True
    if user.id in ALLOWED_USER_IDS:
        return True
    if user.username and user.username.lower() in ALLOWED_USERNAMES:
        return True
    return False

# Inline mode needs a public URL for the video/thumbnail (Telegram fetches
# them itself), so generated media is cached here briefly and served by a
# small web server running alongside the bot. media_id -> (bytes, content_type, expires_at)
media_cache: dict[str, tuple[bytes, str, float]] = {}
MEDIA_TTL_SECONDS = 300
PUBLIC_BASE_URL = os.environ.get("PUBLIC_BASE_URL", "").rstrip("/")

# Inline query result id -> (Segment, total_duration_ms, expires_at). Lets
# the chosen_inline_result handler know what was sent and whether it needs
# to chain another spin by editing the inline message in place, since
# inline mode gives no chat_id to send a follow-up message with.
pending_inline_results: dict[str, tuple["Segment", int, str, float]] = {}


@dataclass
class Segment:
    wheel_label: str
    reveal_text: str = ""
    kind: str = "number"  # "number" | "bonus" | "respin" | "prize"
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
    if not _is_allowed(update.effective_user):
        await update.message.reply_text("🔒 Este bot es privado, no puedes usarlo.")
        return

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
        f"Usa /ruleta para girar la ruleta por defecto (dificultad Easy): {default_labels} "
        "(dinero a pagar 💸).\n"
        "Las casillas que ponen \"TIRA OTRA VEZ\" te hacen pagar Y además "
        "gira otra vez sola (puede encadenarse varias veces seguidas) hasta "
        "caer en una casilla normal, y entonces se suma todo lo que tienes "
        "que pagar.\n\n"
        "Elige dificultad con /ruleta e (Easy), /ruleta m (Medium) o "
        "/ruleta h (Hard) — cuanto más difícil, mayores importes y más "
        "probabilidad de \"TIRA OTRA VEZ\".\n\n"
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
    if not _is_allowed(update.effective_user):
        await update.message.reply_text("🔒 Este bot es privado, no puedes usarlo.")
        return

    difficulty_arg = context.args[0].lower() if len(context.args) == 1 else None

    if difficulty_arg in DIFFICULTIES:
        difficulty_name, segments = DIFFICULTIES[difficulty_arg]
        await update.message.reply_text(f"🎚 Dificultad: *{difficulty_name}*", parse_mode=ParseMode.MARKDOWN)
    else:
        segments = parse_custom_segments(context.args)

        if segments is None and context.args:
            await update.message.reply_text(
                "⚠️ Solo puedo girar con números enteros, o e/m/h para elegir "
                "dificultad. Ejemplo:\n/ruleta 5 10 15 20\n/ruleta m"
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


def _cache_media(data: bytes, content_type: str) -> str:
    media_id = uuid.uuid4().hex
    media_cache[media_id] = (data, content_type, time.time() + MEDIA_TTL_SECONDS)
    return media_id


def _cleanup_media_cache() -> None:
    now = time.time()
    expired = [key for key, (_, _, expires_at) in media_cache.items() if expires_at < now]
    for key in expired:
        media_cache.pop(key, None)


async def handle_media_request(request: web.Request) -> web.Response:
    entry = media_cache.get(request.match_info["media_id"])
    if not entry:
        return web.Response(status=404)
    data, content_type, _ = entry
    return web.Response(body=data, content_type=content_type)


async def _generate_spin_media(segments: list[Segment]) -> tuple[Segment, str, str, int, int, int]:
    """Spins the wheel once and returns (winner, video_url, thumb_url, duration_ms, width, height)."""
    winning_index = random.randrange(len(segments))
    winner = segments[winning_index]
    wheel_labels = [segment.wheel_label for segment in segments]

    loop = asyncio.get_running_loop()
    video_bytes, total_duration_ms, width, height, thumbnail_bytes = (
        await loop.run_in_executor(None, build_spin_video, wheel_labels, winning_index)
    )

    video_id = _cache_media(video_bytes, "video/mp4")
    thumb_id = _cache_media(thumbnail_bytes, "image/png")

    video_url = f"{PUBLIC_BASE_URL}/media/{video_id}.mp4"
    thumb_url = f"{PUBLIC_BASE_URL}/media/{thumb_id}.png"
    return winner, video_url, thumb_url, total_duration_ms, width, height


def _cleanup_pending_results() -> None:
    now = time.time()
    expired = [key for key, (_, _, _, expires_at) in pending_inline_results.items() if expires_at < now]
    for key in expired:
        pending_inline_results.pop(key, None)


async def inline_ruleta(update: Update, context: ContextTypes.DEFAULT_TYPE) -> None:
    if not PUBLIC_BASE_URL or not _is_allowed(update.effective_user):
        await update.inline_query.answer([], cache_time=0)
        return

    _cleanup_media_cache()
    _cleanup_pending_results()

    query = update.inline_query.query.strip().lower()
    difficulty_key = query if query in DIFFICULTIES else "e"
    difficulty_name, segments = DIFFICULTIES[difficulty_key]

    winner, video_url, thumb_url, total_duration_ms, width, height = (
        await _generate_spin_media(segments)
    )

    if winner.payment:
        caption = _payment_message(winner.value, respin=winner.kind == "bonus")
    else:
        caption = winner.reveal_text or "🎰 ¡Ruleta girada!"

    result_id = uuid.uuid4().hex
    pending_inline_results[result_id] = (
        winner,
        total_duration_ms,
        difficulty_key,
        time.time() + MEDIA_TTL_SECONDS,
    )

    # Telegram only assigns an inline_message_id (needed to edit this
    # message later, for the auto-respin chain) if it has a reply_markup.
    keyboard = InlineKeyboardMarkup(
        [[InlineKeyboardButton("🎰 Girar otra vez", switch_inline_query_current_chat=difficulty_key)]]
    )

    result = InlineQueryResultVideo(
        id=result_id,
        video_url=video_url,
        mime_type="video/mp4",
        thumbnail_url=thumb_url,
        title=f"🎰 Girar la ruleta ({difficulty_name})",
        description="Escribe e / m / h después del bot para elegir dificultad",
        caption=caption,
        parse_mode=ParseMode.MARKDOWN,
        video_duration=round(total_duration_ms / 1000),
        video_width=width,
        video_height=height,
        reply_markup=keyboard,
    )

    await update.inline_query.answer([result], cache_time=0, is_personal=True)


async def inline_result_chosen(update: Update, context: ContextTypes.DEFAULT_TYPE) -> None:
    chosen = update.chosen_inline_result
    inline_message_id = chosen.inline_message_id
    logger.info(
        "chosen_inline_result recibido: result_id=%s inline_message_id=%s",
        chosen.result_id,
        inline_message_id,
    )

    entry = pending_inline_results.pop(chosen.result_id, None)
    if entry is None or not inline_message_id:
        logger.warning(
            "chosen_inline_result sin datos pendientes o sin inline_message_id "
            "(entry=%s, inline_message_id=%s)",
            entry is not None,
            inline_message_id,
        )
        return

    winner, total_duration_ms, difficulty_key, _expires_at = entry
    _difficulty_name, segments = DIFFICULTIES[difficulty_key]
    logger.info("Ganador inicial: %s (kind=%s)", winner.wheel_label, winner.kind)

    total = winner.value
    history = [winner.wheel_label.replace("\n", " ")]
    is_payment = winner.payment
    current_kind = winner.kind
    wait_ms = total_duration_ms

    for _ in range(MAX_RESPINS):
        if current_kind != "bonus":
            break

        await asyncio.sleep(wait_ms / 1000)

        new_winner, video_url, thumb_url, wait_ms, width, height = (
            await _generate_spin_media(segments)
        )

        if new_winner.payment:
            caption = _payment_message(new_winner.value, respin=new_winner.kind == "bonus")
        else:
            caption = new_winner.reveal_text or "🎰 ¡Ruleta girada!"

        await context.bot.edit_message_media(
            inline_message_id=inline_message_id,
            media=InputMediaVideo(
                media=video_url,
                caption=caption,
                parse_mode=ParseMode.MARKDOWN,
                width=width,
                height=height,
                duration=round(wait_ms / 1000),
            ),
        )

        total += new_winner.value
        history.append(new_winner.wheel_label.replace("\n", " "))
        is_payment = is_payment or new_winner.payment
        current_kind = new_winner.kind

    if len(history) > 1 and current_kind != "bonus":
        await asyncio.sleep(wait_ms / 1000)
        breakdown = " + ".join(history)
        label = "Total a pagar" if is_payment else "Total acumulado"
        suffix = "€" if is_payment else ""
        await context.bot.edit_message_caption(
            inline_message_id=inline_message_id,
            caption=f"🧮 {label} ({breakdown}) = *{total}{suffix}*",
            parse_mode=ParseMode.MARKDOWN,
        )


async def _start_web_server(application: Application) -> None:
    port = int(os.environ.get("PORT", "8080"))
    web_app = web.Application()
    web_app.router.add_get("/media/{media_id}.{ext}", handle_media_request)
    runner = web.AppRunner(web_app)
    await runner.setup()
    site = web.TCPSite(runner, "0.0.0.0", port)
    await site.start()
    application.bot_data["web_runner"] = runner
    logger.info("Servidor de medios escuchando en el puerto %s", port)


async def _stop_web_server(application: Application) -> None:
    runner = application.bot_data.get("web_runner")
    if runner:
        await runner.cleanup()


def main() -> None:
    token = os.environ.get("TELEGRAM_BOT_TOKEN")
    if not token:
        raise SystemExit(
            "Falta la variable de entorno TELEGRAM_BOT_TOKEN con el token del bot."
        )

    application = (
        Application.builder()
        .token(token)
        .post_init(_start_web_server)
        .post_shutdown(_stop_web_server)
        .build()
    )

    async def log_error(update: object, context: ContextTypes.DEFAULT_TYPE) -> None:
        logger.exception("Excepción no controlada", exc_info=context.error)

    application.add_handler(CommandHandler("start", start))
    application.add_handler(CommandHandler("ruleta", ruleta))
    application.add_handler(CommandHandler("ruletagente", ruleta_gente))
    application.add_handler(CommandHandler("unirme", unirme))
    application.add_handler(InlineQueryHandler(inline_ruleta))
    application.add_handler(ChosenInlineResultHandler(inline_result_chosen))
    application.add_handler(
        MessageHandler(filters.ChatType.GROUPS & ~filters.COMMAND, track_member)
    )
    application.add_error_handler(log_error)

    logger.info("Bot iniciado. Esperando comandos...")
    application.run_polling(allowed_updates=Update.ALL_TYPES)


if __name__ == "__main__":
    main()
