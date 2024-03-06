FROM php:8.2-fpm

ARG REDIS_VERSION=7.0.11
# ARG MCRYPT_VERSION=1.0.1
ARG RDKAFKA_VERSION=6.0.3

RUN apt-get update &&\
    apt-get install -y openssl libssl-dev libcurl4-openssl-dev pkg-config libsasl2-dev libpcre3-dev &&\
    apt-get install -y libc-client-dev libkrb5-dev libpng-dev libxml2-dev libmcrypt-dev &&\
    apt-get install -y libgpgme11-dev &&\
    apt-get install -y libfreetype6-dev libjpeg62-turbo-dev &&\
    apt-get install -y --no-install-recommends librdkafka-dev &&\
    pecl install rdkafka-${RDKAFKA_VERSION} &&\
    # pecl install mcrypt-${MCRYPT_VERSION} &&\
    pecl install redis-${REDIS_VERSION} &&\
    pecl install gnupg

RUN docker-php-ext-install zip \
    && docker-php-ext-install pcntl \
    && docker-php-ext-configure imap --with-imap-ssl --with-kerberos \
    && docker-php-ext-install imap \
    && docker-php-ext-install exif \
    && docker-php-ext-configure bcmath \
    && docker-php-ext-install bcmath \
    && docker-php-ext-enable redis \
    && docker-php-ext-install sockets \
    && docker-php-ext-enable gnupg \
    && docker-php-ext-install pdo pdo_mysql \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install gd \
    && docker-php-ext-enable rdkafka

# Install composer
ARG COMPOSER_VERSION=2.5.8
ENV COMPOSER_HOME /var/composer/
RUN mkdir -m 777 -p /var/composer/ \
    && curl -sS https://getcomposer.org/installer | php -- \
        --filename=composer \
        --version=${COMPOSER_VERSION} \
        --install-dir=/usr/local/bin

USER root

# Install supervisor, cron
RUN  apt-get update \
        && apt-get install -y supervisor \
            && mkdir /var/supervisor \
            && touch /var/supervisor/supervisor.log \
        && apt-get install -y cron procps \
        && rm -rf /var/lib/apt/lists/*

# Add local web-user
ARG WEB_USER_ID=1000
ARG WEB_USER_NAME=yondu

COPY ./custom.ini /usr/local/etc/php/conf.d/custom.ini
COPY ./supervisord.conf  /var/supervisor/supervisord.conf
COPY ./crontab.cfg /var/spool/cron/crontabs/${WEB_USER_NAME}
COPY ./supervisorctl /var/supervisor/supervisorctl

RUN useradd -m -u ${WEB_USER_ID} ${WEB_USER_NAME} || echo "User exists" \
    && ln -sf /proc/1/fd/1 /var/supervisor/supervisor.log \
    && chown -R ${WEB_USER_ID}:${WEB_USER_ID} /var/supervisor \
    && crontab -u ${WEB_USER_NAME} /var/spool/cron/crontabs/${WEB_USER_NAME}

WORKDIR '/var/supervisor'
ENV SUPERVISOR_USER ${WEB_USER_NAME}
ENV CONFIG_NAME /var/supervisor/supervisord.conf
ENV SUPERVISOR_API_USERNAME supervisor
ENV SUPERVISOR_API_PASSWORD supervisor

COPY ./entrypoint.sh /run/entrypoint.sh
CMD ["sh", "/run/entrypoint.sh"]
