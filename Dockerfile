# Gunakan base image PHP 8.2 dengan Apache
FROM php:8.2-apache

# Install dependency system untuk ekstensi PHP (GD perlu freetype & jpeg)
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libxml2-dev \
    libonig-dev \
    libcurl4-openssl-dev \
    unzip \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" \
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
        opcache \
        curl \
    && a2enmod rewrite \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Salin Composer dari image resmi Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set direktori kerja ke root CI4 dan salin seluruh source
WORKDIR /var/www/html
COPY . /var/www/html

# Konfigurasi Composer dan install dependensi untuk produksi
ENV COMPOSER_ALLOW_SUPERUSER=1 COMPOSER_MEMORY_LIMIT=-1
RUN composer config --no-interaction allow-plugins.codeigniter4/framework true \
  && composer config --no-interaction allow-plugins.kylekatarnls/update-helper true || true \
  && composer install --no-dev --optimize-autoloader --prefer-dist --no-interaction --no-progress

# Buat virtual host Apache menunjuk ke public nested app (hindari heredoc agar stabil)
RUN set -eux; \
  printf '%s\n' \
    '<VirtualHost *:80>' \
    '    ServerName localhost' \
    '    DocumentRoot /var/www/html/public' \
    '    <Directory /var/www/html/public>' \
    '        AllowOverride All' \
    '        Require all granted' \
    '    </Directory>' \
    '</VirtualHost>' \
    > /etc/apache2/sites-available/ci4-runtime.conf; \
  a2ensite ci4-runtime; \
  a2dissite 000-default

# Set permission untuk folder writable dan uploads (buat jika belum ada)
RUN mkdir -p /var/www/html/writable /var/www/html/public/uploads /var/www/html/uploads \
  && chown -R www-data:www-data /var/www/html/writable /var/www/html/public/uploads /var/www/html/uploads \
  && chmod -R 775 /var/www/html/writable /var/www/html/public/uploads /var/www/html/uploads

# Konfigurasi opcache produksi
RUN set -eux; echo \
  "opcache.enable=1\n" \
  "opcache.enable_cli=1\n" \
  "opcache.memory_consumption=128\n" \
  "opcache.interned_strings_buffer=8\n" \
  "opcache.max_accelerated_files=20000\n" \
  "opcache.validate_timestamps=0\n" \
  > /usr/local/etc/php/conf.d/opcache.ini

# Expose port HTTP
EXPOSE 80

# Jalankan Apache
CMD ["apache2-foreground"]
