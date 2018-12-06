# Telegram notification by email

+ 
+ https://api.telegram.org/bot<token>/setWebhook?url=https://www.example.com/my-telegram-bot
+ https://api.telegram.org/bot{my_bot_token}/getWebhookInfo
+ https://api.telegram.org/bot<token>/deleteWebhook
+ https://core.telegram.org/bots/api#setwebhook

## What do you have to do
+ Create your telegram bot https://core.telegram.org/bots#3-how-do-i-create-a-bot
+ get the bot token
+ talk with the botfather command: /setprivacy  'Disable' - your bot will receive all messages that people send to group
+ set the webhook https://api.telegram.org/bot<token>/setWebhook?url=https://www.example.com/my-telegram-bot
+ upload all files of this repo to a webserver (https only)
+ fill out the settings in telegram_notification.php

