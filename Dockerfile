
FROM php:8.2-cli

WORKDIR /app

RUN apt-get update && apt-get install -y unzip git curl \
    && docker-php-ext-install pdo pdo_mysql

COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer
COPY . .

RUN composer install --no-interaction

CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
