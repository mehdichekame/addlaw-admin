# ---------- Stage 1: PHP + Composer ----------
FROM php:8.3-fpm as php_builder

RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev libxml2-dev libzip-dev \
    libicu-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip intl

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader


# ---------- Stage 2: Node (Vite build) ----------
FROM node:20-alpine as node_builder

WORKDIR /app
COPY --from=php_builder /var/www /app

RUN npm install
RUN npm run build


# ---------- Stage 3: Final runtime ----------
FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    libpng-dev libzip-dev \
    && docker-php-ext-install pdo_mysql gd zip

WORKDIR /var/www

COPY --from=php_builder /var/www /var/www
COPY --from=node_builder /app/public/build /var/www/public/build

RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 9000
CMD ["php-fpm"]
