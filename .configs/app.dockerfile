FROM schedulia/php-dev:0.0.2

USER root
RUN docker-php-ext-install pdo_mysql
USER $USERNAME
