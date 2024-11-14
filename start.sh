#!/bin/bash

# Build and start containers in detached mode
docker-compose up -d --build

docker-compose exec app cp .env.example .env

docker-compose exec app composer install

docker-compose exec app php artisan key:generate

./wait-for-it.sh mysql:3306 --timeout=10 --strict -- echo "MySQL is up - executing command"

docker-compose exec app php artisan migrate:fresh

# Run Laravel migrations
docker-compose exec app php artisan db:seed --force

