# ============================================
# Stage 1: Build frontend assets
# ============================================
FROM node:22-alpine AS frontend

WORKDIR /app

COPY package*.json ./
RUN npm ci

COPY resources ./resources
COPY public ./public
COPY vite.config.* ./
COPY package.json ./

RUN npm run build


# ============================================
# Stage 2: Laravel + Apache
# ============================================
FROM php:8.2-apache

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

# System dependencies + PHP extensions
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    curl \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        pdo_pgsql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        zip \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*


# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer


WORKDIR /var/www/html

# Copy Laravel application
COPY . .


# Install production PHP dependencies
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --prefer-dist


# Copy Vite production build
COPY --from=frontend /app/public/build ./public/build


# Apache configuration
RUN printf '%s\n' \
    '<VirtualHost *:80>' \
    '    DocumentRoot /var/www/html/public' \
    '    <Directory /var/www/html/public>' \
    '        AllowOverride All' \
    '        Require all granted' \
    '    </Directory>' \
    '</VirtualHost>' \
    > /etc/apache2/sites-available/000-default.conf


# Laravel writable directories
RUN chown -R www-data:www-data \
    storage \
    bootstrap/cache


EXPOSE 80


# Start Laravel
CMD ["sh", "-c", "php artisan migrate --force && php artisan db:seed --force && apache2-foreground"]