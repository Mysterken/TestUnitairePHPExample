# Utilisation d'une image officielle PHP en tant qu'image de base
FROM php:latest

# Installation de Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Installation de PHPUnit
RUN apt-get update && apt-get install -y git \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && curl -L https://phar.phpunit.de/phpunit-10.phar -o /usr/local/bin/phpunit \
    && chmod +x /usr/local/bin/phpunit

# Installation de Xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Installation de SQLite 3 et vim
RUN apt-get install -y sqlite3 libsqlite3-dev vim

RUN echo "xdebug.mode=coverage" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/xdebug.ini

# Définition du répertoire de travail
WORKDIR /app

# Commande par défaut à exécuter lorsque le conteneur démarre
CMD ["php", "-S", "0.0.0.0:8000"]

# Exposer le port 8000 pour l'accès aux applications web
EXPOSE 8000


# Commande :

# docker build -t php-composer-phpunit .
# docker run -it -p 8000:8000 -v ./app/:/app --name php-container php-composer-phpunit
# docker exec -it php-container /bin/bash