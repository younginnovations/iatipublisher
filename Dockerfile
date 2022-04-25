FROM serversideup/php:8.1-fpm-nginx

ENV APP_NAME=iatipublisher
ENV APP_ENV=production
ENV APP_KEY=base64:TI6LnCLWTKZTVIvK31iPlGJtXcR6n1GADMhCp8RTBWQ=
ENV APP_DEBUG=false
ENV DEBUGBAR_ENABLED=false
ENV APP_URL=https://iatipublisher-staging.caprover.staging.yipl.com.np
ENV APP_TIMEZONE=Asia/Kathmandu
ENV APP_LOCALE=ne
ENV APP_LOCALE_FULL_CODE=ne_NP
ENV LOG_HORIZON=false
ENV LOG_CHANNEL=daily
ENV LOG_LEVEL=debug
ENV DB_CONNECTION=pgsql
ENV DB_HOST=srv-captain--hrmms-db
ENV DB_PORT=5432
ENV DB_DATABASE=iatipublisher_staging
ENV DB_USERNAME=iatipublisher
ENV DB_PASSWORD=27c55d0459
ENV BROADCAST_DRIVER=log
ENV CACHE_DRIVER=redis
ENV QUEUE_CONNECTION=redis
ENV SESSION_DRIVER=redis
ENV SESSION_LIFETIME=120
ENV SESSION_SECURE_COOKIE=true
ENV MEMCACHED_HOST=127.0.0.1
ENV REDIS_HOST=srv-captain--hrmms-redis
ENV REDIS_PASSWORD=5Swx6ol4PFE9
ENV REDIS_PORT=6379
ENV MAIL_MAILER=smtp
ENV MAIL_HOST=mailhog
ENV MAIL_PORT=1025
ENV MAIL_USERNAME=null
ENV MAIL_PASSWORD=null
ENV MAIL_ENCRYPTION=null
ENV MAIL_FROM_ADDRESS=no-reply@iatipublisher.local
ENV MAIL_FROM_NAME=${APP_NAME}
ENV IATI_API_ENDPOINT=https://staging.iatiregistry.org/api
ENV IATI_API_KEY=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpYXQiOjE2NDYyMDA5NTQsImp0aSI6ImpGNXdObVhZWC1wUlF0dU9wUnRMM1pGVDRvc0hzWmk0MFZ3UnpobURFTDAifQ.6pYkDD0dtH8dG---d59uTlW3vtri9mL1Y5KCeOG9chQ
ENV IATI_USERNAME=derilinx
ENV IATI_PASSWORD=staging.derilinx

RUN apt-get update \
    && apt-get install -y --no-install-recommends php8.1-pgsql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

COPY --chown=webuser:webgroup . /var/www/html/

RUN composer install
RUN composer du
RUN php artisan config:clear
RUN php artisan migrate --force
RUN php artisan db:seed --force
