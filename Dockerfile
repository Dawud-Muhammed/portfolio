FROM node:22-bookworm-slim AS frontend
WORKDIR /app

COPY package.json package-lock.json ./
RUN npm ci

COPY resources ./resources
COPY public ./public
COPY vite.config.js tailwind.config.js postcss.config.js ./
RUN npm run build

FROM php:8.4-cli-bookworm

WORKDIR /var/www/html

ENV APP_ENV=production \
    APP_DEBUG=false \
    APP_URL=http://localhost:8000 \
    LOG_CHANNEL=stderr \
    DB_CONNECTION=mysql \
    DB_HOST=mysql \
    DB_PORT=3306 \
    DB_DATABASE=portfolio \
    DB_USERNAME=portfolio_user \
    DB_PASSWORD=portfolio_pass \
    CACHE_STORE=file \
    SESSION_DRIVER=file \
    QUEUE_CONNECTION=sync

RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    unzip \
    libicu-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    default-mysql-client \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" \
        bcmath \
        exif \
        gd \
        intl \
        mbstring \
        pcntl \
        pdo \
        pdo_mysql \
        zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY composer.json composer.lock ./
RUN composer install --no-dev --prefer-dist --no-interaction --no-progress --optimize-autoloader --no-scripts

COPY . .
COPY --from=frontend /app/public/build ./public/build

RUN mkdir -p storage/app/public storage/framework/cache storage/framework/sessions storage/framework/testing storage/framework/views bootstrap/cache \
    && php artisan package:discover --ansi \
    && chown -R www-data:www-data /var/www/html

USER www-data

EXPOSE 8000

CMD ["/bin/sh", "-c", "\
if [ ! -f .env ]; then cp .env.example .env; fi && \
php artisan key:generate --force && \
(php artisan storage:link || true) && \
php artisan config:clear && \
php artisan cache:clear && \
until php artisan migrate --force; do \
  echo 'MySQL is unavailable - waiting 5s...' && sleep 5; \
done && \
php artisan serve --host=0.0.0.0 --port=8000 \
"]