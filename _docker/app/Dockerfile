FROM composer:2.8.1 as vendor

WORKDIR /var/www

COPY database/ database/
COPY composer.json composer.json
COPY composer.lock composer.lock

RUN composer install \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --no-dev \
    --prefer-dist

COPY . .
RUN composer dump-autoload

FROM php:8.3-fpm

RUN apt-get update \
    && apt-get install -y \
      apt-utils \
      libpq-dev \
      libpng-dev \
      libzip-dev \
      zip unzip \
      libxml2-dev \
      git \
      libjpeg-dev \
      libjpeg-turbo-progs \
      libfreetype-dev \
      libfreetype6-dev \
      libspng-dev \
      libwebp-dev

RUN docker-php-ext-configure gd --with-freetype --with-webp --with-jpeg && \
    docker-php-ext-install -j$(nproc) gd && \
    docker-php-ext-install -j$(nproc) pdo && \
    docker-php-ext-install -j$(nproc) pdo_mysql && \
    docker-php-ext-install -j$(nproc) bcmath && \
    docker-php-ext-install -j$(nproc) zip && \
    docker-php-ext-install -j$(nproc) opcache && \
    docker-php-ext-install -j$(nproc) bcmath && \
    docker-php-ext-install -j$(nproc) pcntl && \
    docker-php-ext-install -j$(nproc) xml && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

COPY ./_docker/app/php.ini /usr/local/etc/php/conf.d/php.ini

WORKDIR /var/www

COPY --from=vendor /var/www/vendor/ ./vendor/
COPY . .

COPY .env.example .env

RUN php artisan key:generate
RUN php artisan migrate --force
RUN php artisan config:cache
RUN php artisan route:cache
