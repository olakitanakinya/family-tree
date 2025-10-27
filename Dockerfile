FROM php:8.2-fpm

WORKDIR /var/www

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev libonig-dev libxml2-dev libzip-dev libfreetype6-dev libjpeg62-turbo-dev \
    nginx supervisor zip unzip curl git netcat-openbsd

# Configure GD extension
RUN docker-php-ext-configure gd --with-freetype --with-jpeg

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring gd zip exif

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy application files
COPY . .

# Install composer dependencies (no scripts to avoid database issues)
RUN COMPOSER_MEMORY_LIMIT=-1 composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

# Copy configuration files
COPY docker/nginx.conf /etc/nginx/sites-available/default
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Create health check endpoint
RUN echo '<?php header("Content-Type: application/json"); http_response_code(200); echo json_encode(["status" => "healthy", "service" => "laravel", "timestamp" => date("c")]); ?>' > /var/www/public/health.php

# Set proper permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Create default .env file
RUN cp .env.example .env 2>/dev/null || true

EXPOSE 80

CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
