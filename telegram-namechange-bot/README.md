# Bot de cambios de nombre para Telegram

Bot que vigila los grupos donde se le añade y avisa cuando alguien cambia su
nombre o su @usuario (similar a SangMata).

## Cómo funciona

- Detecta cambios de nombre/usuario comparando cada mensaje nuevo de una
  persona con el último nombre/usuario que le vio usar.
- Solo conoce a partir del momento en que el bot está en el grupo y esa
  persona escribe algo; no tiene historial previo a eso, y ese registro se
  guarda en memoria (se pierde si el bot se reinicia).
- `/setlog` (dentro de un grupo) — hace que ese grupo sea el destino de
  todos los avisos de cambios detectados en cualquier grupo donde esté el
  bot, en vez de avisar en el propio grupo donde ocurrió el cambio.

## Instalación

1. Crea un bot con [@BotFather](https://t.me/BotFather) y copia el token.
2. Instala las dependencias:

   ```bash
   pip install -r requirements.txt
   ```

3. Configura el token:

   ```bash
   cp .env.example .env
   # Edita .env y pon tu token en TELEGRAM_BOT_TOKEN
   export $(cat .env | xargs)
   ```

4. Ejecuta el bot:

   ```bash
   python bot.py
   ```

## Despliegue

Igual que cualquier bot de Telegram por *long polling*: despliega en un
servicio que ejecute procesos Python de larga duración (Railway, un VPS,
etc.) con `TELEGRAM_BOT_TOKEN` como variable de entorno y `python bot.py`
como comando de arranque.
