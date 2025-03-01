#!/bin/sh

git pull

composer install --no-dev --no-interaction --optimize-autoloader --prefer-dist

php artisan migrate --force

php artisan install

php artisan config:cache

php artisan event:cache

php artisan view:clear

php artisan permissions:create

php artisan filament:optimize
