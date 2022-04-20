FROM httpd:2.4.48-alpine

ARG DEBIAN_FRONTEND=noninteractive
RUN apk update; \
    apk upgrade; \
    apk add openrc;
COPY default.conf /usr/local/apache2/conf/php.conf
COPY httpd.conf /usr/local/apache2/conf/httpd.conf

RUN sed -i '/LoadModule rewrite_module/s/^#//g' /usr/local/apache2/conf/httpd.conf && \
    sed -i 's#AllowOverride [Nn]one#AllowOverride All#' /usr/local/apache2/conf/httpd.conf