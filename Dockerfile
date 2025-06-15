FROM php:8.3-fpm-alpine

# Instalar dependências do sistema para PostgreSQL
RUN apk update && apk add --no-cache \
    postgresql-dev \
    && docker-php-ext-install pgsql

# Copiar arquivos do projeto
COPY . /var/www/html/

# Instalar NGINX
RUN apk add --no-cache nginx

# Configurar NGINX
COPY nginx.conf /etc/nginx/conf.d/default.conf

# Permissões
RUN chown -R www-data:www-data /var/www/html

# Expor porta 80 para NGINX
EXPOSE 80

# Iniciar NGINX e PHP-FPM
CMD ["sh", "-c", "nginx && php-fpm"]