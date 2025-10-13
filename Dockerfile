# Gunakan base image PHP 8.2 dengan Apache
FROM php:8.2-apache

# Install dependency system untuk ekstensi PHP
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libzip-dev \
    libpng-dev \
    libxml2-dev \
    libonig-dev \
    unzip \
    git \
    && docker-php-ext-install \
        intl \
        pdo \
        pdo_mysql \
        mysqli \
        gd \
        mbstring \
        xml \
        zip \
        bcmath \
        exif \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Aktifkan mod_rewrite untuk CodeIgniter
RUN a2enmod rewrite

# Salin Composer dari image resmi Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set direktori kerja
WORKDIR /var/www/html

# Copy semua file project
COPY . .

# Install dependensi PHP dari composer.json
RUN COMPOSER_ALLOW_SUPERUSER=1 composer install --no-dev --optimize-autoloader

# Set permission untuk folder writable
RUN chown -R www-data:www-data writable && chmod -R 775 writable

# Konfigurasi Apache agar mendukung .htaccess
RUN echo '<Directory /var/www/html/public>\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>' > /etc/apache2/conf-available/ci4.conf \
    && a2enconf ci4

# Expose port HTTP
EXPOSE 80

# Jalankan Apache
CMD ["apache2-foreground"]
