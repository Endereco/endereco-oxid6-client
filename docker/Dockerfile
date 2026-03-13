ARG PHP_VERSION=8.1
FROM php:${PHP_VERSION}-apache

# System dependencies
RUN apt-get update && apt-get install -y \
        libpng-dev \
        libjpeg-dev \
        libwebp-dev \
        libfreetype6-dev \
        libzip-dev \
        libxml2-dev \
        libicu-dev \
        libonig-dev \
        libcurl4-openssl-dev \
        netcat-openbsd \
        default-mysql-client \
        curl \
        git \
        unzip \
    && rm -rf /var/lib/apt/lists/*

# PHP extensions required by OXID 6
RUN docker-php-ext-configure gd --with-jpeg --with-webp --with-freetype \
    && docker-php-ext-install -j$(nproc) \
        bcmath \
        curl \
        exif \
        gd \
        gettext \
        intl \
        mbstring \
        opcache \
        pdo_mysql \
        soap \
        zip

# XDebug: installed but NOT enabled by default.
# The playground.sh activates it on request via docker exec.
RUN pecl install xdebug && rm -rf /tmp/pear

# Enable Apache modules
RUN a2enmod rewrite headers

# Composer 2
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Install OXID via Composer.
# OXID_COMPOSER_VERSION examples:
#   dev-b-6.3-ce  →  OXID 6.3 (latest on branch)
#   dev-b-6.4-ce  →  OXID 6.4 (latest on branch)
#   dev-b-6.5-ce  →  OXID 6.5 (latest on branch)
ARG OXID_COMPOSER_VERSION=dev-b-6.5-ce
RUN composer config --global audit.block-insecure false \
    && composer config --global allow-plugins true \
    && composer create-project \
        --no-dev \
        --no-interaction \
        oxid-esales/oxideshop-project . ${OXID_COMPOSER_VERSION}

# Install Guzzle — required by the Endereco module but not part of OXID itself.
# In production this is pulled in by `composer require endereco/endereco-oxid6-client`;
# in the playground the module is volume-mounted, so we install the dependency here.
RUN composer require --update-no-dev --no-interaction "guzzlehttp/guzzle:^6.3|^7.3.0"

# Create placeholder for the Endereco module (replaced by volume mount at runtime)
# and register its PSR-4 namespace so the autoloader knows the path.
COPY docker/patch-composer.php /tmp/patch-composer.php
RUN mkdir -p source/modules/endereco/endereco-oxid6-client \
    && php /tmp/patch-composer.php \
    && rm /tmp/patch-composer.php \
    && composer dump-autoload --no-dev --optimize

# AdminNeo — single-file database manager (MySQL-only build)
RUN mkdir -p /var/www/adminneo \
    && curl -fsSL -o /var/www/adminneo/index.php \
       "https://www.adminneo.org/files/latest/mysql_en_default/adminneo-latest.php"

# PHP dev configuration
COPY docker/php.ini /usr/local/etc/php/conf.d/oxid-dev.ini

# Apache virtual host
COPY docker/apache.conf /etc/apache2/sites-available/000-default.conf

# Permissions
RUN chown -R www-data:www-data /var/www/html

# Startup script
COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

EXPOSE 80

ENTRYPOINT ["/entrypoint.sh"]
CMD ["apache2-foreground"]
