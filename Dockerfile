FROM alpine:3.17

RUN apk update
RUN apk upgrade


RUN apk add bash
RUN apk add curl
RUN apk add php81
RUN apk add php81-phar
RUN apk add php81-iconv
RUN apk add php81-mbstring
RUN apk add php81-openssl
RUN apk add php81-ctype
RUN apk add php81-xml
RUN apk add php81-sodium
RUN apk add php81-tokenizer
RUN apk add php81-session
RUN apk add php81-dom
RUN apk add php81-intl
RUN apk add php81-pdo
RUN apk add php81-pdo_mysql
RUN apk add php81-fpm
RUN apk add nginx
RUN apk add nodejs
RUN apk add npm
RUN apk add sudo

RUN curl -s https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer

RUN mkdir /app

WORKDIR /app

COPY package.json .
COPY package-lock.json .
RUN npm install

COPY composer.json .
COPY composer.lock .
RUN composer install

COPY bin bin
COPY config config
COPY webpack.config.js .
COPY .env .
COPY docker/.env.local .
RUN mkdir ./public
COPY ./public/index.php ./public
RUN mkdir ./var
RUN chmod a+x bin/console

COPY assets assets
COPY migrations migrations
COPY src src
COPY templates templates

RUN npm run build

RUN bin/console cache:clear
RUN bin/console assets:install

RUN rm -rf var/*

COPY docker/www.conf /etc/php81/php-fpm.d/www.conf
COPY docker/default.conf /etc/nginx/http.d/default.conf

CMD sudo -u nobody bin/console doctrine:database:create --if-not-exists && sudo -u nobody bin/console doctrine:schema:update --force && php-fpm81 && nginx -g 'daemon off;'