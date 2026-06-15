FROM php:8.4-fpm

RUN apt-get update && apt-get install -y \
    git curl unzip zip libpng-dev libonig-dev libxml2-dev nodejs npm

RUN docker-php-ext-install pdo pdo_mysql mbstring bcmath

RUN pecl install redis \ && docker-php-ext-enable redis

RUN npm install -g pm2

WORKDIR /var/www/laravel
