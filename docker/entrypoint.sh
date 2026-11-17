#!/usr/bin/env bash
set -e

cd /var/www/html

if [ ! -f .env ]; then
    cp .env.docker .env
fi

if ! grep -q '^APP_KEY=base64:' .env; then
    php artisan key:generate --force
fi

echo "Menunggu MySQL (${DB_HOST:-db}:${DB_PORT:-3306}) siap..."
until php -r "new PDO('mysql:host='.(getenv('DB_HOST')?:'db').';port='.(getenv('DB_PORT')?:'3306'), getenv('DB_USERNAME')?:'g7kaih', getenv('DB_PASSWORD')?:'g7kaih_secret');" >/dev/null 2>&1; do
    sleep 2
done

php artisan migrate --force

USER_COUNT=$(php -r "
require 'vendor/autoload.php';
\$app = require 'bootstrap/app.php';
\$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
echo App\Models\User::count();
" 2>/dev/null || echo "0")

if [ "${USER_COUNT}" = "0" ]; then
    echo "Database masih kosong, menjalankan DatabaseSeeder..."
    php artisan db:seed --force
fi

chown -R www-data:www-data storage bootstrap/cache

php-fpm -D
exec nginx -g "daemon off;"
