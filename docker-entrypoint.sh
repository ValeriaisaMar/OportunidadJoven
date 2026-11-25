#!/bin/sh
set -e
cd /var/www/html

# Render indica el puerto en la variable PORT
PORT="${PORT:-10000}"
sed -ri "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf
sed -ri "s/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf

php artisan package:discover --ansi || true
php artisan storage:link || true
php artisan migrate --force

chown -R www-data:www-data storage bootstrap/cache
exec apache2-foreground
