FROM php:8.4-fpm-alpine

RUN docker-php-ext-install pdo_mysql

RUN echo "log_errors=On" > /usr/local/etc/php/conf.d/logging.ini \
    && echo "error_log=/var/log/php/error.log" >> /usr/local/etc/php/conf.d/logging.ini

WORKDIR /var/www/html