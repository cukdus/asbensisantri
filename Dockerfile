# Gunakan image PHP + Apache
FROM php:8.2-apache

# Install ekstensi PHP yang dibutuhkan CodeIgniter
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Aktifkan mod_rewrite agar CI4 bisa handle route dengan benar
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy semua file dari repo
COPY . /var/www/html

# Set permission untuk folder writable CI4
RUN chown -R www-data:www-data /var/www/html/writable \
    && chmod -R 775 /var/www/html/writable

# Expose port 80
EXPOSE 80
