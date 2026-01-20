# --- Stage 1: Build Assets (Tailwind/Vite) ---
FROM node:20-alpine as frontend
WORKDIR /app
COPY package*.json vite.config.js ./
RUN npm install
COPY resources/ ./resources/
COPY public/ ./public/
# Build assets (hasilnya akan ada di public/build)
RUN npm run build

# --- Stage 2: PHP Setup ---
FROM php:8.2-fpm

# Install dependencies sistem
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libsqlite3-dev

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions yang dibutuhkan Laravel
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd pdo_sqlite

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy seluruh file project
COPY . /var/www

# Copy hasil build frontend dari Stage 1
COPY --from=frontend /app/public/build /var/www/public/build

# Install dependency PHP (tanpa dev dependencies untuk prod)
RUN composer install --optimize-autoloader --no-dev

# Permission (PENTING untuk SQLite)
# Kita set owner ke www-data agar Nginx/PHP bisa tulis ke database.sqlite
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache /var/www/database

EXPOSE 9000
CMD ["php-fpm"]