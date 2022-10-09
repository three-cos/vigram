FROM nginx:1.17

RUN usermod -u 1000 www-data && groupmod -g 1000 www-data
RUN usermod -s /bin/bash www-data

RUN touch /var/log/nginx.log

COPY default.conf /etc/nginx/conf.d/default.conf

WORKDIR /app
