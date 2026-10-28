#!/bin/bash
set -e

# Configurar puerto dinámico de Render (por defecto 80 o $PORT)
PORT="${PORT:-80}"
sed -i "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf
sed -i "s/:80/:${PORT}/" /etc/apache2/sites-available/*.conf

echo "===> Iniciando EduCapacita en Render (Puerto: ${PORT})..."

# Garantizar que APP_KEY exista y sea una clave base64 válida
if [ -z "$APP_KEY" ] || [[ "$APP_KEY" != base64:* ]]; then
    export APP_KEY="base64:2LL7QAgZ+CAmTZDp4UalyY3h74H5Ka3ErFDYh45enHQ="
fi

# Crear estructura de carpetas de almacenamiento si no existen
mkdir -p /var/www/html/storage/framework/{sessions,views,cache,testing}
mkdir -p /var/www/html/storage/logs
mkdir -p /var/www/html/bootstrap/cache

# Crear archivo de log si no existe para evitar fallos de permisos
touch /var/www/html/storage/logs/laravel.log

# Limpiar cachés anteriores
php artisan config:clear || true
php artisan route:clear || true
php artisan view:clear || true

# Esperar conexión a la base de datos PostgreSQL
echo "===> Comprobando conexión a la base de datos PostgreSQL..."
for i in {1..20}; do
    if php artisan db:show >/dev/null 2>&1 || php artisan migrate:status >/dev/null 2>&1; then
        echo "===> Conexión a PostgreSQL establecida con éxito."
        break
    fi
    echo "Intento $i/20: Esperando disponibilidad de la base de datos..."
    sleep 3
done

# Ejecutar migraciones y seeders
if [ "${RUN_MIGRATIONS}" = "true" ] || [ "${RUN_MIGRATIONS}" = "1" ]; then
    echo "===> Ejecutando migraciones de base de datos..."
    php artisan migrate --force

    if [ "${RUN_SEEDER}" = "true" ] || [ "${RUN_SEEDER}" = "1" ]; then
        echo "===> Ejecutando seeders de datos iniciales..."
        php artisan db:seed --force || echo "===> Seeders ejecutados o ya existentes."
    fi
fi

# Generar cachés de producción
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

# Asignar permisos estrictos de www-data a todo storage y cache
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

echo "===> Servidor web Apache iniciado exitosamente en puerto ${PORT}"
exec apache2-foreground
