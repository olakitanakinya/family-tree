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

# Install composer dependencies WITHOUT running scripts that need database
RUN COMPOSER_MEMORY_LIMIT=-1 composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

# Copy configs
COPY docker/nginx.conf /etc/nginx/sites-available/default
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# ✅ FIXED: Create health check endpoint with proper PHP syntax
RUN echo '<?php\n\
header("Content-Type: application/json");\n\
try {\n\
    $pdo = new PDO("mysql:host=mysql-service;dbname=familytreedb", "familytreeuser", "Password123");\n\
    echo json_encode(["status" => "healthy", "database" => "connected", "timestamp" => date("c")]);\n\
    http_response_code(200);\n\
} catch (Exception $e) {\n\
    echo json_encode(["status" => "unhealthy", "error" => $e->getMessage(), "timestamp" => date("c")]);\n\
    http_response_code(500);\n\
}\n\
?>' > /var/www/public/health.php

# Set proper permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache

EXPOSE 80

CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
