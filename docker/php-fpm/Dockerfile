ARG tag

FROM php:${tag}-fpm

ARG SOURCE_CODE_PATH_CONTAINER

# Install system dependencies
RUN apt-get update && apt-get install -y \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    build-essential \
    libssl-dev \
    zlib1g-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libmagickwand-dev \
    imagemagick \
    supervisor \
    zip \
    unzip \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install mbstring \
    && docker-php-ext-install exif \
    && docker-php-ext-install pcntl \
    && docker-php-ext-install bcmath \
    && docker-php-ext-install gd \
    && docker-php-ext-install zip \
    && docker-php-source delete

# Install Imagick
RUN pecl install imagick
RUN docker-php-ext-enable imagick
RUN docker-php-ext-install exif

# Install Mysql
RUN docker-php-ext-install mysqli
RUN docker-php-ext-install pdo_mysql

# Install GD
RUN docker-php-ext-configure gd --with-freetype --with-jpeg && docker-php-ext-install gd

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Copy composer.lock and composer.json
# COPY src/composer.json* SOURCE_CODE_PATH_CONTAINER/

# Set working directory
WORKDIR ${SOURCE_CODE_PATH_CONTAINER}

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Create symlink
RUN ln -s /root/.composer/vendor/bin/phpcs /usr/bin/phpcs

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Copy existing application directory contents
COPY ../ SOURCE_CODE_PATH_CONTAINER

# Copy existing application directory permissions
COPY --chown=www:www ../ SOURCE_CODE_PATH_CONTAINER

# Change current user to www
USER www
