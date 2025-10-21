# PHP 8.2 Apache con extensiones necesarias
FROM php:8.2-apache

# Instalar dependencias del sistema y extensiones de PHP
RUN apt-get update && apt-get install -y \
    git unzip libpq-dev libicu-dev libonig-dev libxml2-dev libzip-dev libjpeg62-turbo-dev libpng-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        intl mbstring zip gd \
    && docker-php-ext-install pdo pdo_pgsql pgsql \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

# Configurar Apache document root a /var/www/html/public
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf \
    && sed -ri -e 's!/var/www/!/var/www/html/public!g' /etc/apache2/apache2.conf

# Copiar composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Configurar PHP para desarrollo
COPY .docker/php-dev.ini /usr/local/etc/php/conf.d/php-dev.ini

# Instalar dependencias (si existe composer.json)
RUN if [ -f composer.json ]; then composer install --no-interaction --prefer-dist; fi

# Permisos
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
CMD ["apache2-foreground"]
