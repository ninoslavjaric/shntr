FROM php:8.0-fpm-alpine

RUN apk update; \
    apk upgrade;

RUN apk add jpeg libpng-dev openjpeg jpeg-dev libjpeg-turbo-dev
RUN docker-php-ext-configure gd --with-jpeg
RUN docker-php-ext-install -j$(nproc) gd

RUN apk add --no-cache $PHPIZE_DEPS libzip-dev \
     && pecl install -f igbinary redis
#RUN apk add --no-cache $PHPIZE_DEPS \
#    && pecl install xdebug-3.1.3 \
#    && docker-php-ext-enable xdebug

RUN docker-php-ext-install mysqli pdo pdo_mysql

RUN apk add sudo autoconf gcc g++ file make && \
    pecl install mailparse &&\
    mkdir -p /etc/sudoers.d/ && \
    echo 'webmaster ALL=(ALL) NOPASSWD:ALL' > /etc/sudoers.d/webmaster

RUN sed -i 's#pm.max_children = 5#pm.max_children = 25#' /usr/local/etc/php-fpm.d/www.conf && \
    sed -i 's#;pm.max_requests#pm.max_requests#' /usr/local/etc/php-fpm.d/www.conf && \
    sed -i 's#pm.start_servers = 2#pm.start_servers = 5#' /usr/local/etc/php-fpm.d/www.conf && \
    sed -i 's#pm.min_spare_servers = 1#pm.min_spare_servers = 3#' /usr/local/etc/php-fpm.d/www.conf && \
    sed -i 's#pm.max_spare_servers = 3#pm.max_spare_servers = 20#' /usr/local/etc/php-fpm.d/www.conf

RUN sed -i 's#www-data#webmaster#' /usr/local/etc/php-fpm.d/www.conf

RUN echo 'upload_max_filesize = 128M' >> /usr/local/etc/php/php.ini
RUN echo 'post_max_size = 128M' >> /usr/local/etc/php/php.ini
RUN echo 'extension=mailparse.so' >> /usr/local/etc/php/php.ini
RUN echo 'extension=redis.so' >> /usr/local/etc/php/php.ini

RUN adduser -u 1000 -D webmaster

WORKDIR .

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php
RUN rm -f composer-setup.php

RUN mkdir ~/bin && mv composer.phar ~/bin/composer
ENV PATH="/home/webmaster/bin:${PATH}"
