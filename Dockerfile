# Utiliser l'image PHP officielle
FROM php:8.2-cli

# Installer les extensions PHP nécessaires
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    && docker-php-ext-install zip

# Installer Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copier les fichiers du projet dans le conteneur
COPY . /app
WORKDIR /app

# Installer les dépendances du projet
RUN composer install

# Exposer le port que l'application utilisera
EXPOSE 8000

# Commande pour démarrer l'application
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]

