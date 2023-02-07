FROM php:8.1-fpm
# Copy composer.lock and composer.json into the working directory
# Set working directory
WORKDIR /var/www

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

RUN pecl install redis && docker-php-ext-enable redis

RUN curl -s https://deb.nodesource.com/setup_16.x | bash
# Install node
RUN apt-get install -y nodejs

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan Commands
RUN chown -R www-data:www-data \
       /var/www/
  #      /var/www/html/bootstrap/cache
