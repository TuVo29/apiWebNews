FROM php:8.2-apache

# Cài các extension PHP cần thiết
RUN apt-get update && apt-get install -y \
    libzip-dev unzip git curl libpng-dev \
    && docker-php-ext-install pdo pdo_mysql zip gd

# Cài Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy mã nguồn vào container
COPY . /var/www/html/

# Set working directory
WORKDIR /var/www/html/

# Cài đặt Laravel
RUN composer install --no-dev --optimize-autoloader

# Phân quyền
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage

# Enable mod_rewrite
RUN a2enmod rewrite
