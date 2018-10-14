FROM php:7.2-apache

RUN apt-get update \
    && apt-get install -y \
    wget \
    vim \
    git \
    zlib1g-dev \
    librdkafka-dev

RUN docker-php-ext-install -j$(nproc) pdo_mysql zip bcmath

RUN pecl install xdebug-2.6.0 \
    && docker-php-ext-enable xdebug

RUN pecl install rdkafka

RUN a2enmod rewrite

ENV PROJECT_DIR /var/www/opensmarthome

RUN mkdir $PROJECT_DIR \
    && mkdir $PROJECT_DIR/bin \
    && mkdir $PROJECT_DIR/var

ENV APP_ENV=dev

COPY docker/install-composer.sh bin/install-composer.sh

RUN chmod +x bin/install-composer.sh \
    && bin/install-composer.sh $PROJECT_DIR \
    && rm bin/install-composer.sh

COPY docker/web/virtualHost.conf /etc/apache2/sites-available/000-default.conf
COPY docker/xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
COPY docker/secrets.sh /usr/local/bin/secrets.sh
COPY docker/web/start.sh /usr/local/bin/start.sh
COPY docker/php.ini /usr/local/etc/php/php.ini

RUN chmod +x /usr/local/bin/start.sh && chmod +x /usr/local/bin/secrets.sh

WORKDIR $PROJECT_DIR

CMD /usr/local/bin/start.sh
