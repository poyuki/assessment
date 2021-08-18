FROM php:8.0.8-fpm-alpine

ENV TERM="xterm" \
    LANG="C.UTF-8" \
    LC_ALL="C.UTF-8"
ENV DOCKER_CONF_HOME=/opt/docker/
ENV APPLICATION_USER=dev-user \
    APPLICATION_GROUP=application \
    APPLICATION_PATH=/home/application \
    APPLICATION_UID=1000 \
    APPLICATION_GID=1000
ENV XDEBUG_VERSION="3.0.4"

COPY conf/ /etc/

# install dependencies
RUN apk add --no-cache \
    		gcc \
    		libc-dev \
    		make \
    		openssl-dev \
    		pcre-dev \
    		zlib-dev \
    		linux-headers \
    		curl \
    		gnupg1 \
    		libxslt-dev \
    		gd-dev \
    		geoip-dev \
    		perl-dev \
    		autoconf \
    		libtool \
    		automake \
    		git \
    		g++ \
    		cmake \
    		sudo \
            patch \
    	&& apk add --no-cache --virtual .gettext gettext

# Add groups and users

RUN addgroup -g $APPLICATION_GID $APPLICATION_GROUP \
    && echo "%$APPLICATION_GROUP ALL=(ALL) NOPASSWD: ALL" > /etc/sudoers.d/$APPLICATION_GROUP \
    && adduser -h /home/application -D -u $APPLICATION_UID -s /bin/bash -G $APPLICATION_GROUP $APPLICATION_USER
RUN apk add --no-cache file
RUN apk update && apk add --no-cache imagemagick-dev supervisor openssh ca-certificates openssl libwebp-tools sshpass go aom-dev imagemagick jpegoptim optipng pngquant git wget vim nano less tree bash-completion mariadb-client libzip libzip-dev
#RUN go get github.com/Kagami/go-avif \
#    && cd /root/go/src/github.com/Kagami/go-avif \
#    && make all \
#    && mv /root/go/bin/avif /usr/local/bin/avif

STOPSIGNAL SIGQUIT

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

USER dev-user

RUN curl https://raw.githubusercontent.com/git/git/v$(git --version | awk 'NF>1{print $NF}')/contrib/completion/git-completion.bash > /home/application/.git-completion.bash \
    && curl https://raw.githubusercontent.com/git/git/v$(git --version | awk 'NF>1{print $NF}')/contrib/completion/git-prompt.sh > /home/application/.git-prompt.sh
RUN composer global require perftools/php-profiler && composer clear
COPY user/* /home/application/
RUN echo "source ~/bashconfig.sh" >> ~/.bashrc

USER root
RUN chown -R dev-user:application /home/application/
COPY user/* /root/
RUN mkdir -p /opt/php-libs
COPY php/* /opt/php-libs/files/

# activate opcache and jit
RUN mv /opt/php-libs/files/opcache-jit.ini "$PHP_INI_DIR/conf.d/docker-php-opcache-jit.ini"

# install pcntl
RUN docker-php-ext-configure pcntl --enable-pcntl \
    && docker-php-ext-install pcntl

# install pcov
#RUN git clone --depth 1 https://github.com/krakjoe/pcov.git /usr/src/php/ext/pcov \
#    && docker-php-ext-configure pcov --enable-pcov \
#    && docker-php-ext-install pcov \
#    && mv /opt/php-libs/files/pcov.ini "$PHP_INI_DIR/conf.d/docker-php-pcov.ini"

# install xdebug 3.0
RUN git clone -b $XDEBUG_VERSION --depth 1 https://github.com/xdebug/xdebug.git /usr/src/php/ext/xdebug \
    && docker-php-ext-configure xdebug --enable-xdebug-dev \
    && cp /opt/php-libs/files/xdebug.ini "$PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini" \
    && docker-php-ext-install xdebug \
    && mkdir /tmp/debug

## install tideways
#RUN git clone --depth 1 https://github.com/tideways/php-xhprof-extension /usr/src/php/ext/xhprof \
#    && docker-php-ext-configure xhprof \
#    && docker-php-ext-install xhprof \
#    && mkdir -p /opt/docker/profiler \
#    && mv /opt/php-libs/files/xhprof.ini "$PHP_INI_DIR/conf.d/docker-php-ext-xhprof.ini"

RUN docker-php-ext-install pdo_mysql

RUN curl https://raw.githubusercontent.com/git/git/v$(git --version | awk 'NF>1{print $NF}')/contrib/completion/git-completion.bash > /root/.git-completion.bash \
    && curl https://raw.githubusercontent.com/git/git/v$(git --version | awk 'NF>1{print $NF}')/contrib/completion/git-prompt.sh > /root/.git-prompt.sh

RUN docker-php-ext-install sockets
RUN docker-php-ext-install zip
RUN docker-php-ext-install exif

RUN apk add rabbitmq-c-dev
# RUN pecl install amqp
# RUN docker-php-ext-enable amqp # Enable the Extension

RUN pecl install -o -f redis \
&&  rm -rf /tmp/pear \
&&  docker-php-ext-enable redis

RUN docker-php-source extract \
	&& mkdir /usr/src/php/ext/amqp \
	&& curl -L https://github.com/php-amqp/php-amqp/archive/master.tar.gz | tar -xzC /usr/src/php/ext/amqp --strip-components=1 \
	&& docker-php-ext-install amqp \
	&& docker-php-ext-enable amqp

RUN apk add --update --no-cache \
      freetype-dev \
      libjpeg-turbo-dev \
      libpng-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(getconf _NPROCESSORS_ONLN)" gd

# imagick
RUN git clone https://github.com/Imagick/imagick \
    && cd imagick \
    && phpize && ./configure \
    && make \
    && make install

RUN mkdir -p /var/log/supervisord
COPY php/php.ini /usr/local/etc/php/php.ini
EXPOSE 9000 9003
RUN chown -R dev-user:application /var/www
WORKDIR /var/www

COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

ENTRYPOINT entrypoint.sh
