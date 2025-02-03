# Используем php:8.3-fpm как базовый образ
FROM php:8.3-fpm

# Устанавливаем необходимые пакеты
RUN apt-get update && apt-get install -y \
    curl unzip git apt-utils libpq-dev libpng-dev libzip-dev \
    libxml2-dev libjpeg-dev libfreetype6-dev libwebp-dev \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Устанавливаем Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

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

# Создаем рабочую директорию
WORKDIR /var/www

# Копируем весь проект
COPY . .

# Создаем .env перед artisan командами
COPY .env.example .env

# Копируем php.ini
COPY ./_docker/app/php.ini /usr/local/etc/php/conf.d/php.ini

# Устанавливаем зависимости проекта
RUN composer install --no-interaction --no-dev --prefer-dist
RUN composer dump-autoload

# Оптимизация Laravel
RUN php artisan key:generate
RUN php artisan config:cache
RUN php artisan route:cache
