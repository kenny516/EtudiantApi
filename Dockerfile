FROM php:8.2-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    && docker-php-ext-install pdo_pgsql

# Install Composer
COPY --from=composer:2.8.3 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/symfony

# Copy application code
COPY . /var/www/symfony

# Install Symfony CLI (optional)
RUN curl -sS https://get.symfony.com/cli/installer | bash \
    && mv /root/.symfony*/bin/symfony /usr/local/bin/symfony

# Expose port 8000 for Symfony server
EXPOSE 8000

CMD ["php-fpm"]
