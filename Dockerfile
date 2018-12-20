FROM php:7-apache-stretch

COPY . /var/www/html/

RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install bcmath \
    && docker-php-ext-install pgsql \
    && docker-php-ext-install pdo_pgsql
