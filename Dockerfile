FROM php:8.4-apache

ENV DEBIAN_FRONTEND=noninteractive

# 1) System deps + PostgreSQL extension + Node
RUN apt-get update && apt-get install -y --no-install-recommends \
    git curl zip unzip libpq-dev nodejs npm \
    && docker-php-ext-install pdo_pgsql \
    && rm -rf /var/lib/apt/lists/*

# 2) Apache rewrite + headers
RUN a2enmod rewrite headers

# 3) Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 4) App files
WORKDIR /var/www/html
COPY . .

# 5) Install deps + build frontend
RUN composer install --no-interaction --prefer-dist --no-dev --optimize-autoloader \
    && npm install \
    && npm run build

# 6) Permissions
RUN mkdir -p /var/www/html/storage /var/www/html/bootstrap/cache \
    && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 7) Apache public dir
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf \
    && sed -ri 's!<Directory /var/www/>!<Directory ${APACHE_DOCUMENT_ROOT}/>!g' /etc/apache2/apache2.conf

# 8) Run migrations
RUN php artisan migrate --force

# 9) Debug Apache config
RUN apache2ctl -t

# 10) Remove the custom CMD and let the base image handle it
# (Don't specify CMD - the base image already has it)

EXPOSE 80