# Installation

```bash
git clone git@github.com:monark-it/guidejournal.git --branch=sulu
cd guidejournal
cp .env .env.local
docker-compose build
docker-compose up -d
docker-compose exec php php composer.phar install -n 
docker-compose exec php php bin/adminconsole sulu:build dev --destroy -n
docker-compose exec php npm install
docker-compose exec php npm run dev
docker-compose exec php php bin/console server:start 0.0.0.0
```

go to http://localhost:8000

