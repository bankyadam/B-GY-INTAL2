FROM composer AS build
WORKDIR /app
COPY composer.json .
COPY composer.lock .

RUN composer install

FROM php:apache-bullseye

ENV APACHE_DOCUMENT_ROOT /var/www/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
RUN rm -rf /var/www/html

COPY ./public   /var/www/public
COPY ./shared   /var/www/shared
COPY ./templates   /var/www/templates

COPY --from=build /app/vendor/ /var/www/vendor
