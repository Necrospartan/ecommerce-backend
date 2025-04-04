FROM php:8.2-fpm

ENV PHP_OPCACHE_ENABLE=1
ENV PHP_OPCACHE_ENABLE_CLI=0
ENV PHP_OPCACHE_VALIDATE_TIMESTAMPS=1
ENV PHP_OPCACHE_REVALIDATE_FREQ=1

RUN usermod -u 1000 www-data

RUN apt-get update -y
RUN apt-get install -y unzip zip libpq-dev libcurl4-gnutls-dev nginx zlib1g-dev libpng-dev libzip-dev nano
RUN docker-php-ext-install pdo pdo_mysql bcmath curl opcache zip gd

WORKDIR /var/www

# COPY --chown=www-data:www-data .. .

COPY php/php.ini /usr/local/etc/php/php.ini
COPY php/php-fpm.conf /usr/local/etc/php-fpm.d/www.conf
COPY php/opcache.ini /usr/local/etc/php/conf.d/opcache.ini
COPY nginx/nginx.conf /etc/nginx/nginx.conf
COPY entrypoint.sh /usr/local/bin/entrypoint.sh

COPY --from=composer:2.3.5 /usr/bin/composer /usr/bin/composer

# RUN chmod -R 755 /var/www/storage
# RUN chmod -R 755 /var/www/bootstrap
RUN chmod +x /usr/local/bin/entrypoint.sh

ENTRYPOINT [ "entrypoint.sh" ]