FROM serversideup/php:beta-8.1-fpm-nginx

RUN apt-get update \
    && apt-get install -y --no-install-recommends php8.1-pgsql \
    && curl -sL https://deb.nodesource.com/setup_16.x -o /tmp/nodesource_setup.sh \
    && sh /tmp/nodesource_setup.sh \
    && apt-get install -y --no-install-recommends nodejs \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

COPY . /var/www/html/
RUN composer install \
    && composer du \
    && chown -R webuser:webgroup /var/www/html
