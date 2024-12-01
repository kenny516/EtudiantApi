# Use an official PHP image with Apache and PHP 8.2
FROM php:8.2-apache

# Install necessary PHP extensions
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
    zip \
    && apt-get clean

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set the DirectoryIndex to prioritize index.php
RUN echo 'DirectoryIndex index.php' >> /etc/apache2/apache2.conf

# Afficher le contenu du fichier pour vérifier les modifications
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf \
    && echo "----- Config After Modification -----" \
    && cat /etc/apache2/sites-available/000-default.conf


# Enable mod_rewrite
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy project files into the container
COPY . .

# Allow Composer plugins to run (fix for root user)
ENV COMPOSER_ALLOW_SUPERUSER=1

# Install Symfony dependencies
RUN composer install --no-interaction --no-progress --optimize-autoloader --no-dev || composer install --no-dev --no-scripts

# Create the var directory and set permissions
RUN mkdir -p /var/www/html/var && chown -R www-data:www-data /var/www/html/var /var/www/html/public

# Expose port 80 (standard for HTTP)
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
