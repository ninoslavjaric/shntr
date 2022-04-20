FROM php:8.0-fpm-alpine

RUN apk update; \
    apk upgrade;
RUN docker-php-ext-install mysqli pdo pdo_mysql

RUN apk add --no-cache $PHPIZE_DEPS \
    && pecl install xdebug-3.1.3 \
    && docker-php-ext-enable xdebug

RUN adduser -u 1000 -D webmaster
USER webmaster
WORKDIR .

RUN echo $DOCKERFILE_NAME

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php
RUN rm -f composer-setup.php

RUN mkdir ~/bin && mv composer.phar ~/bin/composer
ENV PATH="/home/webmaster/bin:${PATH}"
