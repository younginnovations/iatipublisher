FROM node:16-alpine as builder
WORKDIR /app
COPY . .
RUN npm install \
    && npm run prod

FROM serversideup/php:beta-8.1-fpm-nginx

RUN apt-get update \
    && apt-get install -y --no-install-recommends php8.1-pgsql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

COPY . /var/www/html/
COPY --from=builder /app /var/www/html/
RUN composer install \
    && composer du \
    && chown -R webuser:webgroup /var/www/html
