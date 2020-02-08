FROM php:7.4-fpm

# Install dependencies
RUN apt-get update && apt-get install --no-install-recommends -y \
    build-essential \
    libzip-dev \
    nano \
    unzip 

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install zip

# Enable igbinary & PHP Redis ext using igbinary
RUN pecl install -o -f igbinary && y | pecl install -o -f redis && docker-php-ext-enable redis igbinary

RUN rm -rf /tmp/pear

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]