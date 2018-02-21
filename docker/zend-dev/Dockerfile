FROM richarvey/nginx-php-fpm:latest 
LABEL maintainer="Sebastian Schmidt <sebastian.schmidt@thrivenow.io>"

RUN sed -i -e 's/uri\//uri\/ \/index.php$is_args$args/g' /etc/nginx/sites-enabled/default.conf
RUN sed -i -e 's/\/html/\/html\/public/g' /etc/nginx/sites-enabled/default.conf
RUN sed -i -e 's/$args =404/$args/g' /etc/nginx/sites-enabled/default.conf

ENV APPLICATION_ENV development
