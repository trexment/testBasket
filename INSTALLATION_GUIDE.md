# 🚀 Guía Rápida de Instalación

## Local Development (Windows, Mac, Linux)

```bash
# 1. Clonar proyecto
git clone <repo-url> cuestionario-baloncesto
cd cuestionario-baloncesto

# 2. Copiar configuración
cp .env.example .env

# 3. Instalar PHP dependencies
composer install

# 4. Generar APP_KEY
php artisan key:generate

# 5. Crear base de datos
# Abrir MySQL/MariaDB y ejecutar:
# CREATE DATABASE cuestionario_baloncesto CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

# 6. Ejecutar migraciones (crea tablas)
php artisan migrate --seed

# 7. Instalar Node dependencies
npm install

# 8. Compilar assets
npm run dev

# 9. Crear enlace storage
php artisan storage:link

# 10. Ejecutar servidor
php artisan serve

# 11. Acceder en navegador
# http://localhost:8000
```

### Credenciales de prueba (cambiar en producción):
- **Email Admin:** admin@test.frannunez.es
- **Contraseña:** SecureAdminPassword123!
- **Usuario Normal:** user@test.frannunez.es
- **Contraseña:** password123

---

## Producción en Plesk

```bash
# 1. SSH a tu servidor Plesk
ssh usuario@tu-servidor.com

# 2. Navega al directorio
cd /var/www/vhosts/frannunez.es/test

# 3. Clone or upload files
# ... (usar FTP o git clone)

# 4. Instalar dependencias
composer install --no-dev --optimize-autoloader
npm install && npm run build

# 5. Configurar .env
nano .env
# Editar:
# APP_DEBUG=false
# APP_ENV=production
# DB_DATABASE, DB_USERNAME, DB_PASSWORD

# 6. Ejecutar migraciones
php artisan migrate --force

# 7. Permisos
chmod -R 755 storage bootstrap/cache
chmod 644 .env

# 8. Caché
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## Estructura básica de archivos

```
cuestionario-baloncesto/
├── app/                    # Código PHP (Controllers, Models)
├── config/                 # Archivos de configuración
├── database/              # Migraciones y seeders
├── public/                # Archivos públicos (CSS, JS compilado)
├── resources/             # Vistas Blade y assets sin compilar
├── routes/                # Definición de rutas
├── storage/               # Archivos temporales e imágenes subidas
├── .env                   # Variables de entorno (NO PUBLICAR)
├── .env.example           # Plantilla de .env
├── composer.json          # Dependencias PHP
└── package.json           # Dependencias Node.js
```

---

## Errores comunes

### Error: "No database"
```bash
# Crear base de datos
mysql -u root -p
CREATE DATABASE cuestionario_baloncesto CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT
```

### Error: "Permission denied storage"
```bash
chmod -R 755 storage bootstrap/cache
```

### Error: "APP_KEY not set"
```bash
php artisan key:generate
```

### Assets no cargan
```bash
npm run build
php artisan storage:link
```

---

## Próximos pasos

1. ✅ Instalar y verificar que funciona
2. ✅ Cambiar contraseña admin en `.env`
3. ✅ Agregar más preguntas desde panel admin
4. ✅ Configurar email SMTP para recuperación de contraseña
5. ✅ Desplegar a producción con HTTPS

---

**¿Necesitas ayuda?** Revisa README.md para instrucciones más detalladas.
