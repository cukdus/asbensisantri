# Gunakan base image PHP 8.2 dengan Apache
FROM php:8.2-apache

# Install dependensi dasar & ekstensi PHP yang dibutuhkan CI4
RUN apt-get update && apt-get install -y \
    git zip unzip libzip-dev libpng-dev libjpeg-dev libicu-dev \
    && docker-php-ext-configure gd --with-jpeg \
    && docker-php-ext-install gd mysqli pdo pdo_mysql zip intl opcache \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

# Set working directory di dalam container
WORKDIR /var/www/html

# Copy semua file proyek ke container
COPY . .

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Jalankan composer install otomatis saat build
RUN composer install --no-dev --optimize-autoloader

# Beri izin ke storage dan writable folder
RUN chown -R www-data:www-data /var/www/html/writable /var/www/html/public

# Expose port 80 (Apache)
EXPOSE 80

# Jalankan Apache
CMD ["apache2-foreground"]
