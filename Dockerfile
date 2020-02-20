FROM php:7.2-apache

LABEL maintainer "Raphaël Volt <raphael@ketmie.com>"

RUN apt-get update && apt-get install -y \
    wget \
    nano \
    curl \
    gettext \
    bzip2 \
    libbz2-dev \
    libsqlite3-dev \
    libxml2-dev \
    libfreetype6-dev \
    libgd-dev \
    libmcrypt-dev \
    libmagickwand-dev \
    libmagickcore-dev \
    libssl-dev

# Imagemagick
RUN yes '' | pecl install -f imagick

# Install php extensions
RUN docker-php-ext-install bcmath
RUN docker-php-ext-install bz2
RUN docker-php-ext-install gettext
RUN docker-php-ext-install opcache
RUN docker-php-ext-install zip
RUN docker-php-ext-install pcntl
RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN docker-php-ext-configure gd --with-freetype-dir=/usr --with-jpeg-dir=/usr
RUN docker-php-ext-install gd
RUN docker-php-ext-install gettext
RUN docker-php-ext-install intl
RUN docker-php-ext-enable imagick
RUN pecl install xdebug && docker-php-ext-enable xdebug

# PHPunit 
RUN wget -O phpunit-8.phar https://phar.phpunit.de/phpunit-8.5.2.phar
RUN chmod +x phpunit-8.phar
RUN mv phpunit-8.phar /usr/local/bin/phpunit

# Apache Configuration
RUN a2enmod rewrite
RUN a2enmod headers
COPY ./xdebug-phpunit.ini /usr/local/etc/php/conf.d/

RUN phpunit --version