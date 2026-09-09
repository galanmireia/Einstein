"""Temporary one-time login helper deployed to Railway.

Flow:
1. On startup, sends the Telegram login code to the account's phone/app.
2. The account owner visits /verify?code=12345 from their OWN device to
   complete the login (the code never passes through this session's
   environment). If 2FA is enabled, visit /verify?password=... after.
3. On success, the resulting session string is logged (Railway logs) so
   it can be copied into the real long-running bot as TELEGRAM_SESSION,
   and this temporary service is done.

Never logs the code or password themselves, only success/failure.
"""

import asyncio
import logging
import os

from aiohttp import web
from telethon import TelegramClient
from telethon.errors import SessionPasswordNeededError
from telethon.sessions import StringSession

logging.basicConfig(
    format="%(asctime)s - %(name)s - %(levelname)s - %(message)s",
    level=logging.INFO,
)
logger = logging.getLogger(__name__)

API_ID = int(os.environ["TELEGRAM_API_ID"])
API_HASH = os.environ["TELEGRAM_API_HASH"]
PHONE = os.environ["TELEGRAM_PHONE"]

client = TelegramClient(StringSession(), API_ID, API_HASH)
logged_in = False


async def handle_verify(request: web.Request) -> web.Response:
    global logged_in

    if logged_in:
        return web.Response(text="Ya se completó el login. Puedes cerrar esta pestaña.")

    code = request.query.get("code")
    password = request.query.get("password")

    try:
        if password:
            await client.sign_in(password=password)
        elif code:
            await client.sign_in(phone=PHONE, code=code)
        else:
            return web.Response(text="Falta ?code=XXXXX en la URL", status=400)
    except SessionPasswordNeededError:
        return web.Response(
            text="Esta cuenta tiene verificación en dos pasos. "
            "Visita esta misma URL añadiendo &password=TU_CONTRASEÑA"
        )
    except Exception as exc:
        logger.exception("Error en sign_in")
        return web.Response(text=f"Error: {exc}", status=400)

    me = await client.get_me()
    session_string = client.session.save()
    logger.info("LOGIN OK como %s (@%s) id=%s", me.first_name, me.username, me.id)
    logger.info("SESSION_STRING=%s", session_string)
    logged_in = True

    return web.Response(
        text=f"✅ Login correcto como {me.first_name}. Ya puedes cerrar esta pestaña."
    )


async def start_app() -> None:
    await client.connect()
    await client.send_code_request(PHONE)
    logger.info("Código enviado a %s. Esperando /verify?code=...", PHONE)

    app = web.Application()
    app.router.add_get("/verify", handle_verify)

    port = int(os.environ.get("PORT", "8080"))
    runner = web.AppRunner(app)
    await runner.setup()
    site = web.TCPSite(runner, "0.0.0.0", port)
    await site.start()
    logger.info("Servidor de login escuchando en el puerto %s", port)

    while True:
        await asyncio.sleep(3600)


if __name__ == "__main__":
    asyncio.run(start_app())
