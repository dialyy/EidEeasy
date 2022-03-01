FROM php:7.4-fpm

# Copy composer.lock and composer.json

# Set working directory
WORKDIR /var/www

# Install dependencies
RUN apt-get update && apt-get update && apt-get install -y \
    build-essential \
    default-mysql-client \
    libpng-dev \
    libzip-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    libmagickwand-dev \
    wget \
    lsb-release \
    apt-utils \
    gnupg


# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN pecl install imagick

# Install extensions
RUN docker-php-ext-install pdo_mysql tokenizer exif pcntl zip gd opcache
RUN docker-php-ext-enable imagick
RUN docker-php-ext-install sockets

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www
# Copy existing application directory contents
COPY . /var/www

# Copy existing application directory permissions
RUN chown www:www /var/www
RUN mkdir /var/temp
RUN chown www:www /var/temp

# Change current user to www
USER www

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
