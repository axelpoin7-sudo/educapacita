#!/bin/bash
set -e

# Configurar puerto dinámico de Render (por defecto 80 o $PORT)
PORT="${PORT:-80}"
sed -i "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf
sed -i "s/:80/:${PORT}/" /etc/apache2/sites-available/*.conf

echo "===> Iniciando despliegue de EduCapacita en Render..."
echo "===> Puerto asignado: ${PORT}"

# Limpieza y preparación de cachés
echo "===> Optimizando cachés de Laravel..."
php artisan config:clear || true
php artisan route:clear || true
php artisan view:clear || true

# Ejecutar migraciones y seeders automáticamente si está habilitado
if [ "${RUN_MIGRATIONS}" = "true" ] || [ "${RUN_MIGRATIONS}" = "1" ]; then
    echo "===> Ejecutando migraciones de base de datos..."
    php artisan migrate --force || true

    if [ "${RUN_SEEDER}" = "true" ] || [ "${RUN_SEEDER}" = "1" ]; then
        echo "===> Ejecutando seeders de datos iniciales..."
        php artisan db:seed --force || true
    fi
fi

# Cachés para producción
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

echo "===> Servidor web Apache iniciado exitosamente en puerto ${PORT}"
exec apache2-foreground
