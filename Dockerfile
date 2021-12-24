FROM php:7.4-apache
WORKDIR /var/www/html
COPY . .
RUN apt-get update
RUN apt install zip unzip
RUN ["php","-r copy('https://getcomposer.org/installer', 'composer-setup.php');"]
RUN ["php","composer-setup.php"]
RUN mv composer.phar /usr/local/bin/composer
RUN composer install --no-dev
RUN rm -rf /etc/apache2/sites-available/000-default.conf
RUN mv ./app.conf /etc/apache2/sites-available/000-default.conf && a2enmod rewrite
RUN docker-php-ext-install pdo_mysql
RUN chown -R www-data:www-data storage/
RUN php artisan cache:clear


EXPOSE 8000:80
