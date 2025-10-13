# Gunakan image PHP + Apache (lebih mudah untuk CI4)
FROM php:8.2-apache

# Install dependency dasar + ekstensi PHP
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libonig-dev \
    libxml2-dev \
    libicu-dev \
    pkg-config \
    && docker-php-ext-configure gd --with-jpeg \
    && docker-php-ext-install gd mysqli pdo pdo_mysql zip intl opcache \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

# Set working directory
WORKDIR /var/www/html

# Salin project dari GitHub (sudah dilakukan oleh docker-compose build context)
COPY . /var/www/html

# Install composer (langsung dari source resmi)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Install dependensi CodeIgniter 4
RUN composer install --no-dev --optimize-autoloader

# Beri izin ke folder writable
RUN chown -R www-data:www-data /var/www/html/writable

# Aktifkan Apache rewrite module
RUN a2enmod rewrite

# Konfigurasi Apache untuk CodeIgniter 4
RUN echo "<Directory /var/www/html>\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>" > /etc/apache2/conf-available/ci4.conf \
    && a2enconf ci4

# Port yang diekspos
EXPOSE 80

# Jalankan Apache
CMD ["apache2-foreground"]
