#!/usr/bin/env bash
set -e

echo "Starting Laravel deployment..."

# Make sure Laravel can write cache/log files.
chmod -R ug+rwx storage bootstrap/cache

echo "Clearing old caches..."
php artisan optimize:clear

echo "Running database migrations..."
php artisan migrate --force

echo "Caching Laravel configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Starting Apache..."
exec apache2-foreground
