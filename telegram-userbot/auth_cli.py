"""One-time interactive login helper for the userbot session.

Run in two steps:
  python3 auth_cli.py send_code --phone +34XXXXXXXXX
  python3 auth_cli.py sign_in --phone +34XXXXXXXXX --code 12345
  # if 2FA is enabled and sign_in asks for it:
  python3 auth_cli.py sign_in --phone +34XXXXXXXXX --password "..."

The resulting session is saved to userbot_session.session in this
directory. That file grants full access to the account — never commit
it or share it.
"""

import argparse
import asyncio
import os

from telethon import TelegramClient
from telethon.errors import SessionPasswordNeededError

API_ID = int(os.environ.get("TELEGRAM_API_ID", "38499563"))
API_HASH = os.environ.get("TELEGRAM_API_HASH", "344083c9d1bd6b9fec4f1452dc5ba840")
SESSION_NAME = os.path.join(os.path.dirname(__file__), "userbot_session")


async def send_code(phone: str) -> None:
    client = TelegramClient(SESSION_NAME, API_ID, API_HASH)
    await client.connect()
    await client.send_code_request(phone)
    print("Código enviado a tu cuenta de Telegram. Pásamelo para el siguiente paso.")
    await client.disconnect()


async def sign_in(phone: str, code: str | None, password: str | None) -> None:
    client = TelegramClient(SESSION_NAME, API_ID, API_HASH)
    await client.connect()
    try:
        if code:
            await client.sign_in(phone=phone, code=code)
        elif password:
            await client.sign_in(password=password)
        else:
            print("Falta --code o --password")
            return
    except SessionPasswordNeededError:
        print("Esta cuenta tiene verificación en dos pasos activada.")
        print("Vuelve a ejecutar con --password '<tu contraseña de 2FA>'")
        await client.disconnect()
        return

    me = await client.get_me()
    print(f"Login correcto como: {me.first_name} (@{me.username}) id={me.id}")
    await client.disconnect()


def main() -> None:
    parser = argparse.ArgumentParser()
    subparsers = parser.add_subparsers(dest="action", required=True)

    send_code_parser = subparsers.add_parser("send_code")
    send_code_parser.add_argument("--phone", required=True)

    sign_in_parser = subparsers.add_parser("sign_in")
    sign_in_parser.add_argument("--phone", required=True)
    sign_in_parser.add_argument("--code")
    sign_in_parser.add_argument("--password")

    args = parser.parse_args()

    if args.action == "send_code":
        asyncio.run(send_code(args.phone))
    elif args.action == "sign_in":
        asyncio.run(sign_in(args.phone, args.code, args.password))


if __name__ == "__main__":
    main()
