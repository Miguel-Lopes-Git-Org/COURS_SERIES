# Étape 1 : Build du CSS (Node.js)
FROM node:20-slim AS builder
WORKDIR /app
COPY package.json pnpm-lock.yaml* ./
RUN corepack enable && pnpm install
COPY . .
RUN pnpm run build:css

# Étape 2 : Serveur PHP (Apache)
FROM php:8.2-apache

# Installer les dépendances pour PostgreSQL
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql pgsql

RUN a2enmod rewrite
WORKDIR /var/www/html

# Copier les fichiers du projet et le CSS généré
COPY --from=builder /app /var/www/html/

EXPOSE 80
