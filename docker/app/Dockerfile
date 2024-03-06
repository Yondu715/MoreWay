FROM php:8.2-fpm AS base

# Add global binary directory to PATH and make sure to re-export it
ENV PATH /composer/vendor/bin:$PATH

# Allow Composer to be run as root
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_VERSION 2.6.6
ENV COMPOSER_HOME /composer

RUN apt-get update && apt-get install -y \
    wget \
    autoconf \
    g++ \
    make \
    openssl \
    libssl-dev \
    libcurl4-openssl-dev \
    pkg-config \
    libsasl2-dev \
    libpcre3-dev \
    libc-client-dev \
    libkrb5-dev \
    libpng-dev \
    libxml2-dev \
    curl \
    zip \
    unzip \
    supervisor \
    --no-install-recommends \
    && rm -r /var/lib/apt/lists/*

# Install soap, pcntl, imap
RUN docker-php-ext-configure soap --enable-soap \
    && docker-php-ext-install soap \
    && docker-php-ext-install pcntl \
    && docker-php-ext-configure imap --with-imap-ssl --with-kerberos \
    && docker-php-ext-install imap \
    && docker-php-ext-install exif \
    && docker-php-ext-configure bcmath \
    && docker-php-ext-install bcmath \
    && docker-php-ext-install intl \
    && rm -rf /var/lib/apt/lists/* \
    && apt-get update \
    && docker-php-ext-install pdo pdo_mysql mysqli \
    # Install gd
    && apt-get update \
    && apt-get install -y libfreetype6-dev libjpeg62-turbo-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd

# Install nodejs, npm
# RUN curl -sL https://deb.nodesource.com/setup_14.x | bash - &&\
#     apt-get install nodejs -y

# Setup the Composer installer
RUN curl -o /tmp/composer-setup.php https://getcomposer.org/installer \
  && curl -o /tmp/composer-setup.sig https://composer.github.io/installer.sig \
  && php -r "if (hash('SHA384', file_get_contents('/tmp/composer-setup.php')) !== trim(file_get_contents('/tmp/composer-setup.sig'))) { unlink('/tmp/composer-setup.php'); echo 'Invalid installer' . PHP_EOL; exit(1); }" \
  && php /tmp/composer-setup.php --no-ansi --install-dir=/usr/local/bin --filename=composer --version=${COMPOSER_VERSION} && rm -rf /tmp/composer-setup.php

RUN apt-get update -y

# Install bz2 library git
RUN apt-get update \
    && apt-get install -y git libbz2-dev \
    && docker-php-ext-install bz2

# Install locales
RUN apt-get install -y locales procps &&\
    localedef -c -i ru_RU -f CP1251 ru_RU.CP1251

# Install opcache
RUN docker-php-ext-install opcache &&\
    docker-php-ext-enable opcache

WORKDIR /var/www

RUN ["ln", "-s", "/var/www/src/vendor/bin/phpunit", "/usr/local/bin/phpunit"]

ENV FPM_PM_MAX_CHILDREN 20
ENV FPM_PM_START_SERVERS 3
ENV FPM_PM_MIN_SPARE_SERVERS 3
ENV FPM_PM_MAX_SPARE_SERVERS 8
ENV FPM_PM_MAX_REQUESTS 500
ENV PHP_OPCACHE 0

COPY ./zz-docker.conf /usr/local/etc/php-fpm.d/zz-docker.conf
COPY ./custom.ini /usr/local/etc/php/conf.d/custom.ini

CMD ["php-fpm"]

# Add local web-user
ARG WEB_USER_ID=${WEB_USER_ID}
ARG WEB_USER_NAME=${WEB_USER_NAME}
ARG WEB_GROUP_ID=${WEB_USER_ID}
ARG WEB_GROUP_NAME=${WEB_USER_NAME}
RUN echo "Building for web user: id=${WEB_USER_ID} name=${WEB_USER_NAME} group=${WEB_GROUP_NAME}"
RUN groupadd -g ${WEB_GROUP_ID} ${WEB_GROUP_NAME}|| echo "Group exists"
RUN useradd -m -u ${WEB_USER_ID} ${WEB_USER_NAME} -g ${WEB_GROUP_NAME} || echo "Users exists"
RUN sed -i -- "s/user = www-data/user = ${WEB_USER_NAME}/g" /usr/local/etc/php-fpm.d/www.conf
USER ${WEB_USER_ID}

FROM base AS dev

USER root

ARG XHPROF_VERSION=2.3.9
ARG XDEBUG_VERSION=3.3.1
ARG PHP_PCOV_VERSION=1.0.11

# Install zsh, xdebug, opcache
RUN apt-get update && apt-get install -qqy --no-install-recommends zsh \
    && pecl install xdebug-${XDEBUG_VERSION} xhprof-${XHPROF_VERSION} pcov-${PHP_PCOV_VERSION} \
    && docker-php-ext-enable xdebug xhprof pcov

USER ${WEB_USER_ID}
