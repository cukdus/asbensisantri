# Gunakan image PHP bawaan dengan Apache
FROM php:8.2-apache

# Install ekstensi yang dibutuhkan CodeIgniter
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy semua file project ke dalam container
COPY . .

# Jalankan composer install agar vendor ter-generate otomatis
RUN composer install --no-dev --optimize-autoloader

# Beri izin folder writable
RUN chown -R www-data:www-data writable && chmod -R 775 writable

# Expose port Apache
EXPOSE 80

# Jalankan Apache
CMD ["apache2-foreground"]
