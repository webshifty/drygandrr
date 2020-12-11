# Друг

## Setup the project


```bash
cp .env.example .env

# set variables in .env
TELEGRAM_BOT_TOKEN=
OPEN_WEATHER_MAP_KEY=

# run the server
docker-compose up -d

# install dependencies
docker-compose exec app composer install
npm install

# build static
npm run prod

# run migrations
docker-compose exec app php artisan migrate

# seed db
docker-compose exec app php artisan db:seed

# run ngrok

ngrok http 8080

# set webhook url
curl -XGET https://api.telegram.org/bot{bot_id}:{TELEGRAM_BOT_TOKEN}/setWebhook?url=<ngrok_url>/bot/getupdates

# enjoy Друг
http://localhost:8080
```

### Users

Admin:

```
admin@mail.com
secret
```

Operator:

```
operator@mail.com
secret
```


