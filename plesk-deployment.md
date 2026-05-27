# 🌐 Despliegue en Plesk (VPS)

Esta guía te ayudará a desplegar la aplicación en un servidor VPS con Plesk instalado.

## Requisitos previos

✅ VPS con Plesk (cualquier versión reciente)  
✅ Dominio apuntando al servidor  
✅ PHP 8.2+ instalado en Plesk  
✅ MySQL/MariaDB disponible  
✅ Acceso SSH al servidor  

## Paso 1: Preparar el entorno en Plesk

### 1.1 Crear subdominio

1. Entra a Plesk → **Dominios**
2. Selecciona tu dominio (frannunez.es)
3. Haz clic en **Crear Subdominio**
4. Nombre: `test`
5. Selecciona PHP 8.2 o superior
6. Click en **Aceptar**

### 1.2 Verificar permisos

```bash
# SSH al servidor
ssh usuario@tu-servidor.com

# Navega a la carpeta
cd /var/www/vhosts/frannunez.es/test/

# Verificar permisos
ls -la
```

---

## Paso 2: Descargar código

### Opción A: Git (Recomendado)

```bash
cd /var/www/vhosts/frannunez.es/test/

# Eliminar contenido por defecto
rm -rf .htaccess index.html

# Clonar repositorio
git clone https://github.com/tu-usuario/cuestionario-baloncesto.git .

# (si tienes un repo privado, genera SSH key primero)
```

### Opción B: FTP

1. Descargar el archivo `.zip` del proyecto
2. Usar FTP (FileZilla o similar) para subir a `/var/www/vhosts/frannunez.es/test/`
3. Descomprimir en el servidor

---

## Paso 3: Instalar dependencias

```bash
cd /var/www/vhosts/frannunez.es/test/

# Actualizar composer
composer self-update

# Instalar dependencias (sin dev)
composer install --no-dev --optimize-autoloader

# Instalar Node dependencies
npm install

# Compilar assets
npm run build
```

---

## Paso 4: Configurar base de datos

### 4.1 En Plesk: Crear base de datos

1. Vuelve a Plesk → **Bases de Datos**
2. Click en **Agregar Base de Datos**
3. Nombre: `cuestionario_baloncesto`
4. Usuario: `cuestionario_user` (anotar contraseña)
5. Click en **Aceptar**

### 4.2 Configurar .env

```bash
cd /var/www/vhosts/frannunez.es/test/

# Copiar plantilla
cp .env.example .env

# Editar (usa nano o vi)
nano .env
```

**Valores importantes a cambiar:**

```env
APP_NAME="Cuestionario Baloncesto FEB"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://test.frannunez.es

# Base de datos (datos de Plesk)
DB_CONNECTION=mysql
DB_HOST=localhost (o IP de tu servidor)
DB_PORT=3306
DB_DATABASE=cuestionario_baloncesto
DB_USERNAME=cuestionario_user
DB_PASSWORD=tu_contraseña_aqui

# Admin
ADMIN_EMAIL=tu-email@tudominio.es
ADMIN_PASSWORD=GenerarUnaContraseñaSegura123!

# Mail (configura después si es necesario)
MAIL_MAILER=smtp
MAIL_HOST=smtp.tu-proveedor.com
MAIL_PORT=587
```

---

## Paso 5: Ejecutar migraciones

```bash
cd /var/www/vhosts/frannunez.es/test/

# Generar APP_KEY (importante!)
php artisan key:generate

# Crear tablas y cargar datos de ejemplo
php artisan migrate --force
php artisan db:seed --force

# Caché
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## Paso 6: Permisos y storage

```bash
# Permisos para storage
chmod -R 755 storage bootstrap/cache

# Crear enlace simbólico para archivos subidos
php artisan storage:link

# Permisos .env
chmod 644 .env

# Verificar propietario (opcional)
chown -R nobody:psacln . 2>/dev/null || true
```

---

## Paso 7: Configurar HTTPS/SSL

### En Plesk:

1. **Dominios** → **test.frannunez.es**
2. **SSL/TLS** → **Instalar certificado SSL**
3. Selecciona **Let's Encrypt** (gratuito)
4. Marca **Renovación automática**
5. Click en **Instalar**

---

## Paso 8: Configurar servidor web (.htaccess ya incluido)

Si usas **Nginx** en lugar de Apache, copia el contenido de `nginx.conf.example` en la configuración de Plesk o sigue los pasos:

1. Plesk → **Dominios** → **test.frannunez.es** → **Configuración de Apache/Nginx**
2. Agregar directivas personalizadas

---

## Paso 9: Verificar en navegador

1. Abre `https://test.frannunez.es`
2. Deberías ver la página de inicio
3. Haz clic en **Registrarse** o **Iniciar Sesión**
4. Admin login: `admin@test.frannunez.es` / `GenerarUnaContraseñaSegura123!`

---

## Paso 10: Configurar backups automáticos

### En Plesk:

1. **Herramientas y Utilidades** → **Copias de Seguridad**
2. **Configurar copia de seguridad automática**
3. Selecciona frecuencia (diaria es recomendado)
4. Incluye base de datos
5. Guarda en almacenamiento externo (FTP, S3, etc.)

---

## Mantenimiento

### Ver logs

```bash
# Logs de aplicación
tail -f /var/www/vhosts/frannunez.es/test/storage/logs/laravel.log

# Logs de Apache (si es aplicable)
tail -f /var/www/vhosts/frannunez.es/test/var/log/access_log
```

### Actualizar preguntas

```bash
# Acceso SSH
cd /var/www/vhosts/frannunez.es/test/

# Crear seed personalizado para nuevas preguntas
php artisan make:seeder CustomQuestionsSeeder

# Ejecutar seed
php artisan db:seed --class=CustomQuestionsSeeder
```

### Limpiar caché

```bash
cd /var/www/vhosts/frannunez.es/test/

php artisan cache:clear
php artisan config:cache
php artisan route:cache
```

---

## Troubleshooting

### Error 500: "The stream or file... could not be opened"

```bash
chmod -R 755 storage bootstrap/cache
```

### Error: "SQLSTATE[HY000] [1045]"

```bash
# Verificar credenciales en .env
nano .env

# Verificar conexión
php artisan tinker
> DB::connection()->getPdo();
```

### Assets (CSS/JS) no cargan

```bash
npm run build
php artisan storage:link
php artisan config:cache
```

### Queue/Cron jobs

```bash
# Agregar cron job a Plesk en: Tareas Programadas
# Comando:
php /var/www/vhosts/frannunez.es/test/artisan schedule:run

# Ejecutar cada minuto
```

---

## Checklist Final

- [ ] Dominio apunta correctamente
- [ ] SSL/HTTPS funciona
- [ ] Base de datos conectada
- [ ] Preguntas cargadas
- [ ] Admin login funciona
- [ ] Tests se pueden crear
- [ ] Imágenes se suben correctamente
- [ ] Backups automáticos configurados
- [ ] Logs monitoreados
- [ ] Password admin cambiado

---

## Soporte

Si hay problemas, revisa:

1. `README.md` - Documentación general
2. `INSTALLATION_GUIDE.md` - Instalación local
3. `storage/logs/laravel.log` - Logs de errores

¡Listo! Tu aplicación está en producción. 🎉
