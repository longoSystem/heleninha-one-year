FROM php:8.1-apache
COPY . /var/www/html
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev && docker-php-ext-install gd
CMD ["apache2-foreground"]