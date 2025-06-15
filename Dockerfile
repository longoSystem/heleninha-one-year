FROM php:8.3-apache

# Install system dependencies for PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pgsql

# Enable mod_rewrite
RUN a2enmod rewrite

# Copy custom Apache configuration
COPY servername.conf /etc/apache2/conf-available/servername.conf
RUN a2enconf servername

# Allow .htaccess overrides
RUN sed -i 's/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Copy project files
COPY . /var/www/html/

# Permissions
RUN chown -R www-data:www-data /var/www/html

# Expose port 80 for Apache
EXPOSE 80