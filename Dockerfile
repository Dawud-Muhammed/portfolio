FROM php:8.4-apache

ENV DEBIAN_FRONTEND=noninteractive

# 1) System deps + PostgreSQL extension + Node
RUN apt-get update && apt-get install -y --no-install-recommends \
    git curl zip unzip libpq-dev nodejs npm \
    && docker-php-ext-install pdo_pgsql \
    && rm -rf /var/lib/apt/lists/*

# 2) Apache rewrite
RUN a2enmod rewrite

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
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 7) Apache public dir
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

EXPOSE 80

# IMPORTANT: only start web server here
CMD ["apache2-foreground"]
CMD ["sh", "-lc", "php artisan optimize:clear || true; apache2-foreground"]