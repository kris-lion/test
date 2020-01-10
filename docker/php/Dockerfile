FROM php:7.3-fpm

RUN apt-get update && apt-get install -y \
	git vim wget unzip gnupg htop sudo procps zip \
	libfreetype6-dev \
	libjpeg62-turbo-dev \
	libmariadbclient-dev \ 
	libmemcached-dev \
	libcurl4-gnutls-dev \
	libc-client-dev libkrb5-dev \
	libldap2-dev \
	libxml2-dev \
	libbz2-dev \
	zlib1g-dev \
	libicu-dev \
	htmldoc \
	g++ && apt-get clean 

RUN pecl install -o -f redis
RUN docker-php-ext-enable redis
RUN pecl install apcu
RUN docker-php-ext-enable apcu

RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/
RUN docker-php-ext-configure pcntl --enable-pcntl
RUN docker-php-ext-configure intl --enable-intl
RUN docker-php-ext-configure mbstring --enable-mbstring
RUN docker-php-ext-install -j$(nproc) curl 
RUN docker-php-ext-install -j$(nproc) pdo 
RUN docker-php-ext-install -j$(nproc) pdo_mysql
RUN docker-php-ext-install -j$(nproc) gd
RUN docker-php-ext-install -j$(nproc) mysqli
RUN docker-php-ext-install -j$(nproc) intl
RUN docker-php-ext-install -j$(nproc) pcntl
RUN docker-php-ext-install -j$(nproc) mbstring
RUN docker-php-ext-install -j$(nproc) bcmath
RUN docker-php-ext-install -j$(nproc) ctype
RUN docker-php-ext-install -j$(nproc) opcache

RUN apt install -y libzip-dev
RUN docker-php-ext-install -j$(nproc) zip

RUN docker-php-ext-install -j$(nproc) json
RUN docker-php-ext-install -j$(nproc) tokenizer
RUN docker-php-ext-install -j$(nproc) sockets
# RUN docker-php-ext-install -j$(nproc) pgsql
# RUN docker-php-ext-install -j$(nproc) pdo_pgsql
RUN docker-php-ext-install -j$(nproc) opcache
RUN docker-php-ext-install -j$(nproc) xml

RUN apt-get install -y curl
RUN curl -sL https://deb.nodesource.com/setup_10.x | sudo -E bash -
RUN apt-get update && apt-get install -y nodejs
RUN node -v

# RUN git clone "https://github.com/tideways/php-xhprof-extension.git" && cd php-xhprof-extension && phpize && ./configure && make && make install
# RUN echo "extension=tideways_xhprof.so" > /usr/local/etc/php/conf.d/xhprof.ini
