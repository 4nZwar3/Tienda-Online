
FROM php:8.2-apache

COPY website/ /var/www/html/

RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
