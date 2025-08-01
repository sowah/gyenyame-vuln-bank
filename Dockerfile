FROM php:7.4-apache

RUN docker-php-ext-install mysqli && apt-get update && apt-get install -y netcat

COPY gyenyame_bank/ /var/www/html/

# Set permissions
RUN chown -R www-data:www-data /var/www/html

RUN a2enmod rewrite

EXPOSE 80

CMD ["apache2-foreground"]

# Enable Apache modules
RUN a2enmod rewrite

# Replace default config with ours
COPY apache/000-default.conf /etc/apache2/sites-available/000-default.conf

#Install mysqli
RUN docker-php-ext-install mysqli
