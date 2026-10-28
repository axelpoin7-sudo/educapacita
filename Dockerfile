FROM php:8.3-apache

# Actualizar paquetes e instalar dependencias del sistema y extensiones de PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-install pdo pdo_pgsql pgsql bcmath zip opcache \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Copiar Composer desde la imagen oficial
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Habilitar el módulo rewrite de Apache para las rutas de Laravel
RUN a2enmod rewrite

# Configurar Apache para que apunte a la carpeta public de Laravel y permitir .htaccess
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
RUN echo '<Directory /var/www/html/public>\n    Options Indexes FollowSymLinks\n    AllowOverride All\n    Require all granted\n</Directory>' >> /etc/apache2/apache2.conf

# Directorio de trabajo
WORKDIR /var/www/html

# Copiar el código fuente del proyecto
COPY . .

# Instalar dependencias de producción de Composer
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# Asignar permisos a storage, bootstrap/cache y uploads públicos
RUN mkdir -p /var/www/html/public/uploads/cursos /var/www/html/public/uploads/instructores \
    && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/public/uploads \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/public/uploads

# Copiar y dar permisos al script de arranque
COPY docker/start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

# Exponer los puertos típicos de Render (Render usa $PORT dinámicamente)
EXPOSE 80 10000

CMD ["/usr/local/bin/start.sh"]
