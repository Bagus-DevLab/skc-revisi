#!/usr/bin/env sh
set -e

mkdir -p \
  public \
  storage/app/public \
  storage/framework/cache \
  storage/framework/sessions \
  storage/framework/views \
  storage/logs \
  bootstrap/cache

chown -R www-data:www-data storage bootstrap/cache database 2>/dev/null || true
chmod -R ug+rwX storage bootstrap/cache database 2>/dev/null || true

if [ -d /var/www-public ]; then
  cp -a /var/www-public/. public/
fi

php artisan storage:link >/dev/null 2>&1 || true

if [ "${RUN_MIGRATIONS:-false}" = "true" ]; then
  php artisan migrate --force
fi

if [ "${APP_ENV:-production}" = "production" ]; then
  php artisan config:cache
else
  php artisan config:clear
fi

exec "$@"
