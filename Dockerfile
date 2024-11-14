# Use a base PHP image with required extensions for Laravel
FROM php:8.1-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    nginx

# Install required PHP extensions for Laravel
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set the working directory to /var/www
WORKDIR /var/www

# Copy the application files
COPY . .

# Install Laravel dependencies
RUN composer install --optimize-autoloader --no-dev

# Copy Nginx configuration file
COPY .docker/nginx/nginx.conf /etc/nginx/nginx.conf

# Set permissions for Laravel storage directory
RUN chown -R www-data:www-data /var/www/storage

# Expose port 80 for Nginx
EXPOSE 80

# Define the command to start the application (Nginx and PHP)
CMD ["sh", "-c", "php-fpm & nginx -g 'daemon off;'"]
