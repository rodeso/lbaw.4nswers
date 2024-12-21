#!/bin/bash
set -e

cd /var/www
env >> /var/www/.env
php artisan clear-compiled
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
php artisan schedule:run
php artisan storage:link
php artisan db:seed
php-fpm8.3 -D
nginx -g "daemon off;"
