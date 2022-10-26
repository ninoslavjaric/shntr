FROM php:8.0-fpm-alpine

RUN apk update; \
    apk upgrade;

RUN apk add jpeg libpng-dev openjpeg jpeg-dev libjpeg-turbo-dev
RUN docker-php-ext-configure gd --with-jpeg
RUN docker-php-ext-install -j$(nproc) gd

RUN docker-php-ext-install mysqli pdo pdo_mysql

RUN apk add sudo autoconf gcc g++ file make && \
    pecl install mailparse &&\
    mkdir -p /etc/sudoers.d/ && \
    echo 'webmaster ALL=(ALL) NOPASSWD:ALL' > /etc/sudoers.d/webmaster

RUN sed -i 's#pm.max_children = 5#pm.max_children = 25#' /usr/local/etc/php-fpm.d/www.conf && \
    sed -i 's#;pm.max_requests#pm.max_requests#' /usr/local/etc/php-fpm.d/www.conf && \
    sed -i 's#pm.start_servers = 2#pm.start_servers = 10#' /usr/local/etc/php-fpm.d/www.conf

RUN echo 'upload_max_filesize = 128M' >> /usr/local/etc/php/php.ini
RUN echo 'post_max_size = 128M' >> /usr/local/etc/php/php.ini
RUN echo 'extension=mailparse.so' >> /usr/local/etc/php/php.ini

RUN adduser -u 1000 -D webmaster

USER webmaster
WORKDIR .

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php
RUN rm -f composer-setup.php

RUN mkdir ~/bin && mv composer.phar ~/bin/composer
ENV PATH="/home/webmaster/bin:${PATH}"
