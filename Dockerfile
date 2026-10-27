# ============================================================
# Stage 1: Build frontend assets with Vite
# ============================================================

FROM node:24-bookworm-slim AS frontend

WORKDIR /app

COPY package*.json ./

RUN if [ -f package-lock.json ]; then \
        npm ci; \
    else \
        npm install; \
    fi

COPY . .

RUN npm run build


# ============================================================
# Stage 2: Laravel / PHP production container
# ============================================================

FROM php:8.5-apache-trixie

# Install required Linux packages and PHP extensions.
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    libicu-dev \
    unzip \
    git \
    curl \
    && docker-php-ext-install \
        pdo_pgsql \
        zip \
        intl \
        bcmath \
        opcache \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Enable Apache rewrite support for Laravel routes.
RUN a2enmod rewrite

# Install Composer.
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy Laravel application.
COPY . .

# Install PHP dependencies.
RUN composer install \
    --no-dev \
    --prefer-dist \
    --no-interaction \
    --optimize-autoloader

# Copy production Vite assets from frontend build.
COPY --from=frontend /app/public/build ./public/build

# Laravel must be served from /public.
RUN sed -ri \
    's!/var/www/html!/var/www/html/public!g' \
    /etc/apache2/sites-available/*.conf

# Allow Laravel's public/.htaccess rules.
RUN printf '%s\n' \
    '<Directory /var/www/html/public>' \
    '    AllowOverride All' \
    '    Require all granted' \
    '</Directory>' \
    > /etc/apache2/conf-available/laravel.conf \
    && a2enconf laravel

# Render web services expect port 10000 by default.
RUN sed -i 's/Listen 80/Listen 10000/' \
        /etc/apache2/ports.conf \
    && sed -i \
        's/<VirtualHost \*:80>/<VirtualHost *:10000>/' \
        /etc/apache2/sites-available/000-default.conf

# Give Apache access to Laravel writable directories.
RUN chown -R www-data:www-data \
        /var/www/html/storage \
        /var/www/html/bootstrap/cache \
    && chmod -R ug+rwx \
        /var/www/html/storage \
        /var/www/html/bootstrap/cache

# Copy deployment startup script.
COPY docker/start.sh /usr/local/bin/start-container

RUN chmod +x /usr/local/bin/start-container

EXPOSE 10000

CMD ["/usr/local/bin/start-container"]
