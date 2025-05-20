#!/bin/sh

sudo -u www-data git pull

sudo -u www-data composer install --no-dev --no-interaction --optimize-autoloader

php artisan migrate --force

php artisan install

php artisan config:cache

php artisan event:cache

php artisan view:clear

php artisan filament:optimize
