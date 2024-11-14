#!/bin/bash

# Build and start containers in detached mode
docker-compose up -d --build

# Run Laravel migrations
docker-compose exec app php artisan db:seed --force

