# ==========================================
# 🧱 BASE IMAGE
# ==========================================
FROM php:8.2-apache

# ==========================================
# 🧩 SYSTEM DEPENDENCIES & PHP EXTENSIONS
# ==========================================
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-configure gd --with-jpeg \
    && docker-php-ext-install gd mysqli pdo pdo_mysql zip intl opcache \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

# ==========================================
# 🧰 INSTALL COMPOSER
# ==========================================
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# ==========================================
# 📂 SETUP APP DIRECTORY
# ==========================================
WORKDIR /var/www/html

# Copy composer files first for layer caching
COPY composer.json composer.lock ./

# Install PHP dependencies (optimize autoloader)
RUN composer install --no-dev --optimize-autoloader --prefer-dist --no-interaction || true

# ==========================================
# 📦 COPY APPLICATION SOURCE
# ==========================================
COPY . /var/www/html

# ==========================================
# 🔧 PERMISSIONS & CLEANUP
# ==========================================
RUN chown -R www-data:www-data /var/www/html/writable \
    && chmod -R 775 /var/www/html/writable \
    && rm -rf /var/lib/apt/lists/*

# ==========================================
# ⚙️ APACHE CONFIG (CI4 friendly)
# ==========================================
RUN echo '<Directory /var/www/html>\n\
    AllowOverride All\n\
</Directory>' > /etc/apache2/conf-available/ci4.conf \
    && a2enconf ci4

# ==========================================
# 🚀 BUILD OPTIMIZATION
# ==========================================
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# ==========================================
# ✅ HEALTH CHECK
# ==========================================
HEALTHCHECK --interval=30s --timeout=10s --start-period=20s --retries=3 \
  CMD curl -f http://localhost/ || exit 1

# ==========================================
# ⚡ ENTRY POINT
# ==========================================
EXPOSE 80
CMD ["apache2-foreground"]
