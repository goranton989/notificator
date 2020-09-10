FROM php:7.4-fpm

WORKDIR /tmp

RUN apt-get update && apt-get install -y git libpq-dev supervisor wget

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
        && php -r "if (hash_file('sha384', 'composer-setup.php') === '8a6138e2a05a8c28539c9f0fb361159823655d7ad2deecb371b04a83966c61223adc522b0189079e3e9e277cd72b8897') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
        && php composer-setup.php --install-dir=/bin --filename=composer \
        && php -r "unlink('composer-setup.php');"

RUN pecl install -o -f redis \
    &&  rm -rf /tmp/pear \
    &&  docker-php-ext-enable redis

RUN docker-php-ext-install pdo pdo_pgsql pcntl

COPY ./horizon.conf /etc/supervisor/conf.d/.
COPY ./entrypoint.sh /bin/entrypoint.sh

# Cleanup
RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Give permissions
RUN chown -R www-data:www-data /srv /var/www && chmod +x /bin/entrypoint.sh

WORKDIR /srv