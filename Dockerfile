# Gunakan base image PHP 8.2 dengan Apache
FROM php:8.2-apache

# Set DocumentRoot ke folder public (sesuai struktur CI4)
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

# Install dependensi dasar & ekstensi PHP yang dibutuhkan CI4
RUN apt-get update && apt-get install -y \
    git zip unzip libzip-dev libpng-dev libjpeg-dev libfreetype6-dev libicu-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd mysqli pdo pdo_mysql zip intl opcache \
    && a2enmod rewrite headers \
    && sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!<Directory /var/www/>!<Directory ${APACHE_DOCUMENT_ROOT}>!g' /etc/apache2/apache2.conf \
    && rm -rf /var/lib/apt/lists/*

# Set working directory di dalam container
WORKDIR /var/www/html

# Copy semua file proyek ke container
COPY . .

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Jalankan composer install otomatis saat build
RUN composer install --no-dev --optimize-autoloader

# Pastikan direktori ada dan beri izin ke storage & writable
RUN mkdir -p /var/www/html/uploads /var/www/html/public/uploads /var/www/html/writable \
    && chown -R www-data:www-data /var/www/html/writable /var/www/html/public /var/www/html/uploads

# Set timezone PHP agar konsisten
ENV TZ=Asia/Jakarta
RUN echo "date.timezone = ${TZ}" > /usr/local/etc/php/conf.d/timezone.ini

# Expose port 80 (Apache)
EXPOSE 80

# Jalankan Apache
CMD ["apache2-foreground"]
