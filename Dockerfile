# Utiliser une image PHP officielle avec Apache et PHP 8.2
FROM php:8.2-apache

# Installer les extensions PHP nécessaires
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libpq-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-install \
    intl \
    pdo \
    pdo_pgsql \
    opcache \
    zip

# Installer Composer directement
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Définir le répertoire de travail
WORKDIR /var/www/html

# Copier les fichiers du projet dans le conteneur
COPY . .

# Installer les dépendances de Symfony sans exécuter les scripts post-installation
RUN composer install --optimize-autoloader --no-dev --no-scripts

# Créer le répertoire var pour éviter l'erreur de permissions
RUN mkdir -p /var/www/html/var && chown -R www-data:www-data /var/www/html/var /var/www/html/public

# Configurer le port pour Apache
EXPOSE 8000

# Commande pour démarrer Apache
CMD ["apache2-foreground"]
