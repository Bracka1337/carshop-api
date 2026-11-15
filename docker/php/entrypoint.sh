#!/bin/sh
set -e
cd /var/www/html

# The storage volume starts as a copy of the image's storage folder.
mkdir -p storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs
chown -R www-data:www-data storage

# Keep one app key across container rebuilds by storing it in the storage volume.
if [ -z "$APP_KEY" ]; then
  [ -f storage/app/.app-key ] || php -r 'echo "base64:".base64_encode(random_bytes(32));' > storage/app/.app-key
  APP_KEY="$(cat storage/app/.app-key)"
  export APP_KEY
fi
[ -f .env ] || touch .env

if [ "$1" = "php-fpm" ]; then
  php artisan migrate --force
  # Seed only an empty database, so restarts keep your data.
  if [ "$(php -r 'require "vendor/autoload.php"; $app = require "bootstrap/app.php"; $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap(); echo App\Models\User::count();')" = "0" ]; then
    php artisan db:seed --force
  fi
  php artisan optimize
fi

exec "$@"
