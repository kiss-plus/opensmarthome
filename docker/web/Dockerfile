FROM php:7.2-apache

RUN apt-get update \
    && apt-get install -y \
    wget \
    vim \
    git \
    zlib1g-dev

RUN docker-php-ext-install -j$(nproc) pdo_mysql zip

RUN pecl install xdebug-2.6.0 \
    && docker-php-ext-enable xdebug


RUN a2enmod rewrite

ENV PROJECT_DIR /var/www/opensmarthome

RUN mkdir $PROJECT_DIR \
    && mkdir $PROJECT_DIR/bin \
    && mkdir $PROJECT_DIR/var

WORKDIR $PROJECT_DIR

COPY docker/web/install-composer.sh bin/install-composer.sh

RUN chmod +x bin/install-composer.sh \
    && bin/install-composer.sh $PROJECT_DIR \
    && rm bin/install-composer.sh

COPY assets assets
COPY bin/console bin/console
COPY config config
COPY public public
COPY src src
COPY templates templates
COPY translations translations
COPY composer.json composer.json
COPY composer.lock composer.lock

RUN bin/composer install

COPY docker/web/virtualHost.conf /etc/apache2/sites-available/000-default.conf
COPY docker/web/xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

CMD ["apache2ctl", "-e", "info", "-DFOREGROUND"]