FROM php:7.3-apache

RUN apt-get update \
    && apt-get install -y \
        apt-utils \
        libpng-dev \
        libjpeg-dev \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        build-essential \
        mysql-client \
        libbz2-dev \
        libmcrypt-dev \
        libcurl3 \
        libcurl3-dev \
        libzip-dev \
        zip \
        vim \
        software-properties-common \
        gnupg \
        gnupg2 \
        gnupg1 \
    && docker-php-ext-configure gd \
        --with-freetype-dir=/usr/include/ \
        --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install \
        pdo_mysql \
        gd \
        bz2 \
        zip \
        pcntl \
        bcmath \
    && chown -R www-data:www-data /var/www/html \
    && a2enmod rewrite