FROM php:8.3-fpm

COPY ./php-fpm.conf /usr/local/etc/php-fpm.d/www.conf

RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


