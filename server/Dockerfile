FROM php:7.3-apache

RUN apt-get update \
    && apt-get install -y \
        apt-utils \
        libpng-dev \
        libjpeg-dev \
        libjpeg62-turbo-dev \
        libfreetype6-dev \
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
        nodejs \
        yarn \
    && curl -sL https://deb.nodesource.com/setup_11.x | bash - \
    && docker-php-ext-install \
        pdo_mysql \
        bz2 \
        zip \
        pcntl \
        bcmath \
    && a2enmod rewrite \
    && service apache2 restart \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd