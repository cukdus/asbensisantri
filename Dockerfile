# =========================================
# STAGE 1: Build dependencies (Composer)
# =========================================
FROM composer:2 AS builder

WORKDIR /app

# Copy project source
COPY . /app

# Install dependencies (tanpa dev)
RUN composer install --no-dev --optimize-autoloader


# =========================================
# STAGE 2: Runtime (PHP-FPM + Nginx)
# =========================================
FROM php:8.2-fpm-alpine

# Install system dependencies
RUN apk add --no-cache \
    nginx \
    bash \
    supervisor \
    libzip-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    libxml2-dev \
    icu-dev \
    oniguruma-dev \
    git \
    zip \
    unzip \
    && docker-php-ext-configure gd --with-jpeg \
    && docker-php-ext-install gd mysqli pdo pdo_mysql zip intl opcache

# Copy app files from builder
COPY --from=builder /app /var/www/html

# Set working directory
WORKDIR /var/www/html

# Konfigurasi Nginx
RUN mkdir -p /run/nginx

# Konfigurasi PHP-FPM pool
RUN mkdir -p /etc/php8/php-fpm.d

# Buat file konfigurasi Nginx untuk CodeIgniter 4
RUN echo 'server {\n\
    listen 80;\n\
    server_name localhost;\n\
    root /var/www/html/public;\n\
\n\
    index index.php index.html;\n\
\n\
    location / {\n\
        try_files $uri $uri/ /index.php?$query_string;\n\
    }\n\
\n\
    location ~ \.php$ {\n\
        include fastcgi_params;\n\
        fastcgi_pass 127.0.0.1:9000;\n\
        fastcgi_index index.php;\n\
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;\n\
    }\n\
\n\
    location ~ /\.ht {\n\
        deny all;\n\
    }\n\
}' > /etc/nginx/conf.d/default.conf

# Supervisor (menjalankan nginx + php-fpm bersama)
RUN echo "[supervisord]\n\
nodaemon=true\n\
[program:php-fpm]\n\
command=docker-php-entrypoint php-fpm\n\
autostart=true\n\
autorestart=true\n\
[program:nginx]\n\
command=nginx -g 'daemon off;'\n\
autostart=true\n\
autorestart=true\n\
" > /etc/supervisord.conf

# Permissions writable folder
RUN chown -R www-data:www-data /var/www/html/writable

EXPOSE 80

# Jalankan Supervisor (Nginx + PHP-FPM)
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]
