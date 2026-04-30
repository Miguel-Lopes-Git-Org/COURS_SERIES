# Serveur PHP (Apache)
FROM php:8.2-apache

# Installer les dépendances pour PostgreSQL
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql pgsql

RUN a2enmod rewrite
WORKDIR /var/www/html

# Copier les fichiers du projet
COPY . /var/www/html/

EXPOSE 80
