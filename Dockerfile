FROM serversideup/php:8.1-fpm-nginx

RUN apt-get update \
    && apt-get install -y --no-install-recommends php8.1-pgsql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

COPY --chown=webuser:webgroup . /var/www/html/

RUN composer install
RUN composer du
