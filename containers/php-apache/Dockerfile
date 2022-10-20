FROM php:8.1.10-apache-bullseye AS prod

ENV APACHE_DOCUMENT_ROOT=/app/public
ENV APP_ENV=prod
ENV APP_DEBUG=0
# this needs to be set because of production environment
ENV MAILER_DSN='smtp://void'
ENV DATABASE_URL='postgresql://void:void@void:5432/void?serverVersion=14&charset=utf8'

WORKDIR /app

COPY . .
COPY containers/php-apache/conf.d/01-prod.ini /usr/local/etc/php/conf.d/01-prod.ini

# INSTALL SYSTEM DEPENDENCIES
RUN apt-get update && apt-get install -y git \
    unzip \
    curl \
    libpq-dev

RUN mkdir -p var && chown www-data:www-data var

# CHANGE APACHE DOCUMENT ROOT
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN a2enmod rewrite

# INSTALL COMPOSER
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
        && php -r "if (hash_file('sha384', 'composer-setup.php') === '55ce33d7678c5a611085589f1f3ddf8b3c52d662cd01d4ba75c0ee0459970c2200a51f492d557530c71c15d8dba01eae') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
        && php composer-setup.php --install-dir=/bin --filename=composer \
        && php -r "unlink('composer-setup.php');"

# INSTALL PHP DEPENDENCIES
RUN docker-php-ext-install pdo pdo_pgsql opcache

# INSTALL PRODUCTION DEPENDENCIES
RUN composer install --no-dev --optimize-autoloader

FROM prod AS test

ENV APP_ENV=test
ENV APP_DEBUG=1

RUN pecl install xdebug && docker-php-ext-enable xdebug

# we're installing development dependencies too
RUN composer install

# override production settings with development if needed
COPY containers/php-apache/conf.d/02-test.ini /usr/local/etc/php/conf.d/02-test.ini

# development specific installations like xDebug in future
FROM test AS dev

ENV APP_ENV=dev