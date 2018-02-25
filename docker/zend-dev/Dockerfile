FROM richarvey/nginx-php-fpm:latest 
LABEL maintainer="Sebastian Schmidt <sebastian.schmidt@thrivenow.io>"

RUN sed -i -e 's/uri\//uri\/ \/index.php$is_args$args/g' /etc/nginx/sites-enabled/default.conf
RUN sed -i -e 's/\/html/\/html\/public/g' /etc/nginx/sites-enabled/default.conf
RUN sed -i -e 's/$args =404/$args/g' /etc/nginx/sites-enabled/default.conf

ENV APPLICATION_ENV development
RUN mkdir -p /etc/ssl/certs && cd /etc/ssl/certs && openssl req -nodes -newkey rsa:2048 -keyout example.key -out example.csr -subj "/C=GB/ST=London/L=London/O=Global Security/OU=IT Department/CN=example.com" && openssl x509 -req -days 365 -in example.csr -signkey example.key -out example.crt

COPY custom-ssl.conf /etc/nginx/sites-enabled/
COPY custom-http.conf /etc/nginx/sites-enabled/
