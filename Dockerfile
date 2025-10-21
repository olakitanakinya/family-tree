FROM php:8.2-fpm

WORKDIR /var/www

# Install minimal dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev libonig-dev libxml2-dev libzip-dev \
    nginx supervisor zip unzip

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring gd zip

# Copy application
COPY . .

# Install Composer manually if needed
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Try composer install with increased memory limit
RUN COMPOSER_MEMORY_LIMIT=-1 composer install --no-dev --optimize-autoloader --no-interaction || true

# Copy configs
COPY docker/nginx.conf /etc/nginx/sites-available/default
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

EXPOSE 80

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
