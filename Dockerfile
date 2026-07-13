FROM php:8.4-apache

# 1. Install system dependencies, PostgreSQL drivers, and Node.js
RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    curl \
    zip \
    unzip \
    libpq-dev \
    nodejs \
    npm \
    && docker-php-ext-install pdo pdo_pgsql \
    && rm -rf /var/lib/apt/lists/*

# 2. Enable Apache mod_rewrite for Laravel routing
RUN a2enmod rewrite

# 3. Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 4. Set working directory
WORKDIR /var/www/html

# 5. Copy your application files into the container
COPY . .

# 6. Install PHP dependencies securely for production
RUN composer install --no-interaction --prefer-dist --no-dev --optimize-autoloader

# 7. Install Node dependencies and compile Tailwind/Alpine assets
RUN npm install && npm run build

# 8. Set correct file permissions for Laravel's cache and storage
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 9. Configure Apache to point directly to Laravel's /public directory
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 10. Expose the standard web port
EXPOSE 80

# 11. Run Neon database migrations and start the Apache server
CMD php artisan migrate --force && apache2-foreground