FROM phpdockerio/php:8.1-fpm
WORKDIR "/tictactoe"

RUN apt-get update; \
    apt-get -y --no-install-recommends install \
        git \ 
        php8.1-mysql \ 
        php8.1-xdebug; \
    apt-get clean; \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*
