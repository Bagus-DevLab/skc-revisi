# --- Stage 1: Build Assets (Node.js) ---
FROM node:20-alpine as frontend
WORKDIR /app
COPY package*.json ./
# Install only production dependencies first
RUN npm install --omit=dev
COPY . .
# Build assets (hasilnya akan ada di public/build)
RUN npm run build

# --- Stage 2: PHP Setup ---
FROM php:8.2-fpm-alpine

# Install system dependencies
RUN apk add --no-cache \
    git \
    curl \
    libpng-dev \
    libxml2-dev \
    zip \
    unzip \
    sqlite-dev \
    oniguruma-dev \
    gd-dev

# Install PHP extensions for Laravel
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd pdo_sqlite

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy application files
COPY . .

# Copy built assets from frontend stage
COPY --from=frontend /app/public/build /var/www/public/build

# Install composer dependencies
RUN composer install --optimize-autoloader --no-dev

# Set permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache /var/www/database
RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache /var/www/database

EXPOSE 9000
CMD ["php-fpm"]