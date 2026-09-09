# Bot de Ruleta para Telegram

Bot de Telegram que gira una ruleta y devuelve un número al azar (por defecto: 5, 10, 15, 20).

## Cómo funciona

- `/start` — muestra instrucciones.
- `/ruleta` — gira la ruleta con los números por defecto (5, 10, 15, 20) y muestra el resultado.
- `/ruleta 5 10 15 20 25` — gira la ruleta con los números que le pases.

## Instalación

1. Crea un bot con [@BotFather](https://t.me/BotFather) en Telegram y copia el token que te da.
2. Instala las dependencias:

   ```bash
   pip install -r requirements.txt
   ```

3. Configura el token como variable de entorno:

   ```bash
   cp .env.example .env
   # Edita .env y pon tu token en TELEGRAM_BOT_TOKEN
   export $(cat .env | xargs)
   ```

4. Ejecuta el bot:

   ```bash
   python bot.py
   ```

El bot se conecta por *long polling*, así que no necesitas un servidor con dominio público para probarlo.

## Despliegue

Para dejarlo corriendo 24/7 puedes desplegarlo en cualquier servicio que ejecute procesos Python de larga duración (Railway, un VPS, etc.), definiendo `TELEGRAM_BOT_TOKEN` como variable de entorno y ejecutando `python bot.py`.
