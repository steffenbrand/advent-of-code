FROM php:8.1-cli-alpine

WORKDIR /application

RUN apk add --no-cache --virtual .purgable-deps $PHPIZE_DEPS \
    && apk add --no-cache git \
    && pecl install -o -f redis && docker-php-ext-enable redis \
    && pecl install xdebug-3.1.5 && docker-php-ext-enable xdebug \
    && apk add --no-cache yaml-dev && yes | pecl install yaml && docker-php-ext-enable yaml \
    && apk add --no-cache icu-dev && docker-php-ext-install intl \
    && apk add --no-cache oniguruma-dev && docker-php-ext-install mbstring \
    && apk add --no-cache libxml2-dev && docker-php-ext-install dom\
    && apk add --no-cache libsodium-dev && docker-php-ext-install sodium \
    && docker-php-ext-install pdo_mysql\
    && docker-php-ext-install bcmath \
    && docker-php-ext-install pcntl \
    && docker-php-ext-install sockets \
    && rm -rf /var/cache/apk/* /tmp/*

COPY config/conf.d/docker-php-ext-xdebug.ini /usr/local/etc/php/conf.d/

RUN wget https://raw.githubusercontent.com/composer/getcomposer.org/76a7060ccb93902cd7576b67264ad91c8a2700e2/web/installer -O - -q | php -- --quiet \
    && mv composer.phar /usr/bin/composer \
    && mkdir /tools \
    && ln -s /usr/bin/composer /tools/composer.phar

EXPOSE 9000