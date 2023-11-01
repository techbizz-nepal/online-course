FROM php:8.2-fpm-bullseye

USER root


RUN apt-get update && apt-get install -y \
            git \
            libxpm-dev \
            libfreetype6-dev \
            libwebp-dev \
            libjpeg-dev \
            libpng-dev \
            build-essential \
            libssl-dev \
            zlib1g-dev \
            libxml2-dev \
            libzip-dev \
            zip \
            curl \
            unzip \
            vim \
            supervisor
RUN pecl install -o -f redis \
&&  pecl install -o -f xdebug \
&&  rm -rf /tmp/pear \
&&  docker-php-ext-enable redis \
&& docker-php-ext-enable xdebug

RUN docker-php-ext-configure pcntl --enable-pcntl \
    && docker-php-ext-install sockets \
    && docker-php-ext-enable sockets \
    && docker-php-ext-configure intl \
    && docker-php-ext-install pcntl \
    && docker-php-ext-install intl \
    && docker-php-ext-install exif \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install mysqli \
    && docker-php-ext-install zip \
    && docker-php-source delete

RUN docker-php-ext-configure gd \
            --enable-gd \
            --with-jpeg \
            --with-webp \
            --with-xpm \
            --with-freetype \
    # docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install gd
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
# Add a non-root user to prevent files being created with root permissions on host machine.
ARG PGID
ARG PUID
RUN groupadd -g ${PGID} apache && \
    useradd -l -u ${PUID} -g apache -m apache && \
    usermod -p "*" apache -s /bin/bash

###########################################################################
# Set Timezone
###########################################################################

ARG TZ=UTC+05:45
ENV TZ ${TZ}

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

COPY --chown=${PUID}:${PGID} . /var/www

WORKDIR /var/www

RUN chgrp -R ${PUID} storage bootstrap/cache
RUN chmod -R ug+rwx storage bootstrap/cache

USER ${PUID}
EXPOSE 9000
