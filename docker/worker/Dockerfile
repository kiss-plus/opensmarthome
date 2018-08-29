FROM php:7.2

RUN apt-get update \
    && apt-get install -y \
    wget \
    vim \
    git \
    zlib1g-dev

RUN docker-php-ext-install -j$(nproc) pdo_mysql zip bcmath

RUN pecl install xdebug-2.6.0 \
    && docker-php-ext-enable xdebug

ENV PROJECT_DIR /var/opensmarthome

RUN mkdir $PROJECT_DIR \
    && mkdir $PROJECT_DIR/bin \
    && mkdir $PROJECT_DIR/var


ENV APP_ENV=dev

COPY docker/install-composer.sh bin/install-composer.sh
COPY docker/xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
COPY docker/secrets.sh /usr/local/bin/secrets.sh
COPY docker/php.ini /usr/local/etc/php/php.ini

RUN chmod +x bin/install-composer.sh \
    && chmod +x /usr/local/bin/secrets.sh \
    && bin/install-composer.sh $PROJECT_DIR \
    && rm bin/install-composer.sh

WORKDIR $PROJECT_DIR

CMD /usr/local/bin/secrets.sh && $PROJECT_DIR/bin/console rabbitmq:consumer actuators
