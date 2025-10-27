FROM php:8.2-fpm

WORKDIR /var/www

# Install minimal dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev libonig-dev libxml2-dev libzip-dev \
    nginx supervisor zip unzip curl

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring gd zip

# Copy application
COPY . .

# Install Composer manually if needed
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install composer dependencies WITHOUT running scripts that need database
RUN COMPOSER_MEMORY_LIMIT=-1 composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

# Create necessary directories and set proper ownership
RUN mkdir -p /var/www/storage/app/public /var/www/storage/framework/{sessions,views,cache} /var/www/bootstrap/cache
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Copy configs
COPY docker/nginx.conf /etc/nginx/sites-available/default
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Create health check endpoint
RUN echo '<?php header("Content-Type: application/json"); http_response_code(200); echo json_encode(["status" => "healthy", "service" => "laravel", "timestamp" => date("c")]); ?>' > /var/www/public/health.php

# Create .env file with default values
RUN echo "APP_NAME=\"Family Tree App\"" > /var/www/.env
RUN echo "APP_ENV=production" >> /var/www/.env
RUN echo "APP_KEY=base64:9jvjThP6JJA5ENjR2evQ27g3H7YE0OtCG+szdOeUsvM=" >> /var/www/.env
RUN echo "APP_DEBUG=false" >> /var/www/.env
RUN echo "APP_URL=http://localhost" >> /var/www/.env
RUN echo "ASSET_URL=http://localhost" >> /var/www/.env
RUN echo "DB_HOST=mysql-service" >> /var/www/.env
RUN echo "DB_PORT=3306" >> /var/www/.env
RUN echo "DB_DATABASE=familytreedb" >> /var/www/.env
RUN echo "DB_USERNAME=familytreeuser" >> /var/www/.env
RUN echo "DB_PASSWORD=Password123" >> /var/www/.env

EXPOSE 80

CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisor/conf.d/supervisord.conf"]

# Copy PHP-FPM configuration
COPY docker/www.conf /usr/local/etc/php-fpm.d/www.conf

# Ensure proper ownership one more time
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
