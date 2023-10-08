FROM phpdockerio/php:8.1-fpm
WORKDIR "/Test"

# Install Node.js and npm
RUN apt-get update && apt-get install -y curl
RUN curl -sL https://deb.nodesource.com/setup_14.x | bash -
RUN apt-get install -y nodejs

# Install PHP development packages and extensions
RUN apt-get install -y \
    libzip-dev \
    libpq-dev \
    libonig-dev \
    libgd-dev \
    libbz2-dev \
    libxml2-dev \
    zlib1g-dev \
    libssl-dev \
    libcurl4-openssl-dev \
    libjpeg-dev \
    libpng-dev \
    libwebp-dev \
    libfreetype6-dev \
    php-dev

RUN docker-php-ext-configure pdo_mysql && \
    docker-php-ext-configure bcmath && \
    docker-php-ext-install pdo_mysql pdo_pgsql zip opcache exif gd intl sockets bcmath mysqli

RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

# Install npm packages globally
RUN npm install -g npm
