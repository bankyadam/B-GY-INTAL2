FROM composer AS build
WORKDIR /app
COPY composer.json .
COPY composer.lock .

RUN composer install

FROM php:apache-bullseye

RUN mkdir -p /var/lib/vendor
COPY --from=build /app/vendor/ /var/lib/vendor/
