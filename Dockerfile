# Base image PHP + Apache
FROM node:20-alpine AS nodebuild
WORKDIR /app
COPY package.json package-lock.json ./
COPY vite.config.js postcss.config.js tailwind.config.js ./
COPY resources ./resources
COPY public ./public
RUN npm ci
RUN npm run build

FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libfontconfig1 \
    libxrender1 \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    nano \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd zip pdo pdo_mysql mbstring xml

# Enable Apache rewrite module
RUN (a2dismod mpm_event mpm_worker mpm_prefork || true) \
  && rm -f /etc/apache2/mods-enabled/mpm_*.load /etc/apache2/mods-enabled/mpm_*.conf \
  && a2enmod mpm_prefork rewrite

RUN set -eux; \
  apache2ctl -M | grep -E 'mpm_(prefork|event|worker)_module' || true; \
  test "$(apache2ctl -M 2>/dev/null | grep -E -c 'mpm_(prefork|event|worker)_module')" -eq 1

RUN echo 'ServerName localhost' > /etc/apache2/conf-available/servername.conf \
  && a2enconf servername

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY . .

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install PHP dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

COPY --from=nodebuild /app/public/build /var/www/html/public/build

RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

RUN { \
    echo '<Directory /var/www/html/public>'; \
    echo '    AllowOverride All'; \
    echo '    Require all granted'; \
    echo '</Directory>'; \
  } > /etc/apache2/conf-available/laravel.conf \
  && a2enconf laravel

RUN if [ -e /var/www/html/public/storage ] && [ ! -L /var/www/html/public/storage ]; then rm -rf /var/www/html/public/storage; fi \
   && ln -sfn /var/www/html/storage/app/public /var/www/html/public/storage

# Fix permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80

# Start Apache in foreground
CMD ["/bin/sh", "-lc", "rm -f /etc/apache2/mods-enabled/mpm_*.load /etc/apache2/mods-enabled/mpm_*.conf; a2enmod mpm_prefork rewrite >/dev/null 2>&1 || true; apache2ctl -M | grep -E 'mpm_(prefork|event|worker)_module' || true; : \"${PORT:=80}\"; sed -ri -e 's/^Listen 80$/Listen '${PORT}'/g' /etc/apache2/ports.conf; sed -ri -e 's/<VirtualHost \\*:80>/<VirtualHost \\*:'${PORT}'>/g' /etc/apache2/sites-available/000-default.conf; exec apache2-foreground"]
