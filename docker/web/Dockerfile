FROM php:7.1-apache

RUN docker-php-source extract \
    docker-php-ext-install -j$(nproc) \
    pdo-mysql \
    posix \
    mbstring \
    mcrypt \
    dom \
    zip \
    && docker-php-source delete

RUN pecl install xdebug-2.5.0 \
    && docker-php-ext-enable xdebug

RUN apt-get update \
    && apt-get install -y \
    wget \
    vim

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

COPY bin/console bin/console
COPY app app
COPY src src
COPY web web
COPY composer.json composer.json
COPY composer.lock composer.lock
COPY vendor vendor

RUN bin/composer install

EXPOSE 80

COPY docker/web/virtualHost.conf /etc/apache2/sites-available/000-default.conf

CMD ["apache2ctl", "-e", "info", "-DFOREGROUND"]