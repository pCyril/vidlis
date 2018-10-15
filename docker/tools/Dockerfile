FROM ubuntu:16.04

RUN apt-get update && apt-get install -y \
        wget \
        libxml2-dev \
        g++ \
        unzip \
        bzip2 \
        php \
        php-curl \
        php-xml \
        php-pgsql \
        php-mbstring \
        php-zip \
        curl \
        git \
        nodejs \
        postgresql

RUN curl -sL https://deb.nodesource.com/setup_6.x | bash - && \
    apt-get update && apt-get install -y nodejs && \
    npm install -g npm && \
    npm install -g webpack && \
    npm install -g webpack-dev-server && \
    npm install -g karma-cli && \
    npm install -g protractor && \
    npm install -g typescript

RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer

RUN mkdir -p /root/.ssh && printf "Host *\n\tStrictHostKeyChecking no\n\tUserKnownHostsFile=/dev/null\n" > /root/.ssh/config

VOLUME /data
VOLUME /root/.composer
