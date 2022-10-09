FROM php:8.1-fpm

ENV DEBIAN_FRONTEND noninteractive

COPY ./user.ini /usr/local/etc/php/conf.d

RUN apt-get update && apt-get install -y libxml2-dev libpng-dev git unzip wget libzip-dev

RUN docker-php-ext-install soap gd exif zip pdo pdo_mysql

RUN wget https://getcomposer.org/composer.phar && chmod +x composer.phar && mv composer.phar /usr/local/bin/composer

RUN usermod -u 1000 www-data && groupmod -g 1000 www-data && usermod --shell /bin/bash www-data

WORKDIR /app
