#!/bin/sh
#
# deploy.sh — Despliegue de WARAS en el servidor (Hostinger).
#
# USO en el servidor por SSH (subes los archivos por FTP primero, luego):
#   cd ~/laravel_app          (o ~/domains/waras.org.pe/laravel_app según tu hosting)
#   sh deploy.sh
#
# Hace TODO lo necesario tras subir cambios, en un solo comando:
#   - aplica migraciones nuevas (si las hay)
#   - limpia caché de rutas, vistas y config
#
# ⚠️ NUNCA usa "route:cache" — routes/web.php usa closures y se rompería.

echo "🚀 Desplegando WARAS..."

echo "📦 Migraciones..."
php artisan migrate --force

echo "🧹 Limpiando caché (rutas, vistas, config)..."
php artisan route:clear
php artisan view:clear
php artisan config:clear

echo "✅ Despliegue completado."
