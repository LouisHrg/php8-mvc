FROM php:8.0-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y git autoconf g++ make libyaml-dev

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql

# Install YAML extension
RUN  pecl install yaml && echo "extension=yaml.so" > /usr/local/etc/php/conf.d/ext-yaml.ini && docker-php-ext-enable yaml

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www
