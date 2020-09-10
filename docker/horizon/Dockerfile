FROM php:7.4-fpm

WORKDIR /tmp

# Need for horizon
RUN docker-php-ext-install pcntl

RUN pecl install -o -f redis \
    &&  rm -rf /tmp/pear \
    &&  docker-php-ext-enable redis

RUN apt-get update && apt-get install -y supervisor

COPY ./horizon.conf /etc/supervisor/conf.d/.
COPY ./entrypoint.sh /bin/entrypoint.sh

# Cleanup
RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Give permissions
RUN chmod +x /bin/entrypoint.sh

WORKDIR /srv