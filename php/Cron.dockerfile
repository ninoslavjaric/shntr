FROM php:8.0-alpine

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

RUN apk add sudo autoconf gcc g++ file make && pecl install mailparse

RUN echo 'extension=mailparse.so' >> /usr/local/etc/php/php.ini
RUN echo 'extension=redis.so' >> /usr/local/etc/php/php.ini

COPY crontab /var/spool/cron/crontabs/root
COPY periodic /etc/periodic

CMD ["crond", "-f"]
