# Use the official PHP 8.3 FPM image as the base
FROM php:8.3-fpm

# Install system dependencies and required PHP extensions
# Install system dependencies and required PHP extensions
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libicu-dev \        
    libonig-dev \      
    default-mysql-client \  
    git \
    unzip \
    zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && docker-php-ext-install bcmath exif pcntl zip intl pdo pdo_mysql  # Install PDO and PDO MySQL


# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . .


# Set ownership for files
RUN chown -R www-data:www-data /var/www/html

# Install PHP dependencies
RUN composer install --optimize-autoloader --no-dev

# Ensure the .env file exists (copy from .env.example if needed)
RUN cp .env.example .env || true 
# Generate Laravel APP_KEY
RUN php artisan key:generate --no-interaction

# Install Node.js and NPM
RUN curl -sL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get install -y nodejs && \
    npm install && \
    npm run build

# Expose the port
EXPOSE 9000
