#!/bin/sh

cd /var/www

composer install

php artisan migrate

php artisan key:generate

echo "End ..."

