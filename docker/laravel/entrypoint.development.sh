#!/bin/bash
set -e

# composer install
# wait $!
# npm install
# wait $!
php artisan key:generate
wait $!
php artisan migrate
wait $!
exec supervisord -c /etc/supervisor/conf.d/supervisord.development.conf
# php artisan serve --host=0.0.0.0 --port=8000