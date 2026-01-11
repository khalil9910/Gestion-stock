# -------------------------------
# Stage 1: Build frontend (Node/Vite)
# -------------------------------
FROM node:20-alpine AS nodebuild

WORKDIR /app

# Copy package and config files
COPY package*.json vite.config.js postcss.config.js tailwind.config.js ./

# Copy resources and public
COPY resources ./resources
COPY public ./public

# Install dependencies & build
RUN npm ci
RUN npm run build

# -------------------------------
# Stage 2: PHP + Apache
# -------------------------------
FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev libzip-dev \
    libfontconfig1 libxrender1 libonig-dev libxml2-dev \
    zip unzip git curl nano \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd zip pdo pdo_mysql mbstring xml

# Enable Apache rewrite module
RUN a2enmod rewrite

# Set server name to avoid warnings
RUN echo 'ServerName localhost' > /etc/apache2/conf-available/servername.conf \
    && a2enconf servername

# Set working directory
WORKDIR /var/www/html

# Copy Laravel project files
COPY . .

# Copy Composer binary
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install PHP dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# Copy Vite build from node stage
COPY --from=nodebuild /app/public/build /var/www/html/public/build

# Set Apache root to public
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

# Allow Laravel .htaccess overrides
RUN { \
    echo '<Directory /var/www/html/public>'; \
    echo '    AllowOverride All'; \
    echo '    Require all granted'; \
    echo '</Directory>'; \
} > /etc/apache2/conf-available/laravel.conf \
  && a2enconf laravel

# Create storage symlink
RUN if [ -e /var/www/html/public/storage ] && [ ! -L /var/www/html/public/storage ]; then rm -rf /var/www/html/public/storage; fi \
    && ln -sfn /var/www/html/storage/app/public /var/www/html/public/storage

# Fix permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Expose port
EXPOSE 80

# Start Apache in foreground (clean)
CMD ["apache2-foreground"]
