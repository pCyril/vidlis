FROM php:7.2-fpm

RUN echo "Europe/Paris" > /etc/timezone && \
 dpkg-reconfigure --frontend noninteractive tzdata


#fix docker-php-ext-install bug
RUN sed -i 's/docker-php-\(ext-$ext.ini\)/\1/' /usr/local/bin/docker-php-ext-install

# Install memcache extension
RUN set -x \
    && apt-get update && apt-get install -y --no-install-recommends zlib1g-dev unzip libssl-dev libpcre3 libpcre3-dev \
    && cd /tmp \
    && curl -sSL -o php7.zip https://github.com/websupport-sk/pecl-memcache/archive/php7.zip \
    && unzip php7 \
    && cd pecl-memcache-php7 \
    && /usr/local/bin/phpize \
    && ./configure --with-php-config=/usr/local/bin/php-config \
    && make \
    && make install \
    && echo "extension=memcache.so" > /usr/local/etc/php/conf.d/ext-memcache.ini \
    && rm -rf /tmp/pecl-memcache-php7 php7.zip


RUN apt-get update && apt-get install --no-install-recommends -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpq-dev \
        libxml2-dev \
    && docker-php-ext-install \
        iconv \
        pdo_mysql \
        mysqli \
        mbstring \
        xml

COPY ./docker/php/php.ini /usr/local/etc/php/
COPY ./backend /data/backend

RUN curl -sS https://getcomposer.org/installer | php && \
        mv composer.phar /usr/local/bin/composer


CMD ["php-fpm", "-F"]
