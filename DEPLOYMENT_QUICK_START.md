# 🚀 Guía Rápida de Despliegue - Actualización v2.0

## 📋 Antes de Empezar

Asegúrate de tener:
- PHP 8.2 o superior
- MySQL 8.0 o MariaDB 10.3+
- Composer instalado
- Node.js 18+ instalado
- SSH/Terminal acceso al servidor

---

## ⚡ Pasos Rápidos (Local y Plesk)

### 1. **Clonar/Actualizar Repositorio**

```bash
# Si es primera vez:
git clone https://github.com/trexment/testBasket.git
cd testBasket

# Si ya existe:
cd testBasket
git pull origin master
```

### 2. **Instalar Dependencias**

```bash
# PHP
composer install

# Node.js
npm install
```

### 3. **Configurar Entorno**

```bash
# Copiar archivo de ejemplo
cp .env.example .env

# Editar .env con:
# - DB_HOST=localhost
# - DB_DATABASE=cuestionario_baloncesto
# - DB_USERNAME=root
# - DB_PASSWORD=tu_contraseña
# - APP_KEY (generará automáticamente)
```

### 4. **Generar APP_KEY**

```bash
php artisan key:generate
```

### 5. **Crear Base de Datos** (MySQL/MariaDB)

```sql
CREATE DATABASE IF NOT EXISTS cuestionario_baloncesto 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;
```

### 6. **Ejecutar Migraciones**

```bash
# Opción A: Migración limpia (recomendado para nuevo servidor)
php artisan migrate:fresh --seed

# Opción B: Solo migraciones pendientes
php artisan migrate
```

### 7. **Compilar Assets**

```bash
# Producción
npm run build

# O desarrollo con watcher
npm run dev
```

### 8. **Crear Enlace de Almacenamiento**

```bash
php artisan storage:link
```

### 9. **Establecer Permisos** (Importante)

```bash
# Linux/MacOS
chmod -R 755 storage
chmod -R 755 bootstrap/cache
chown -R www-data:www-data storage
chown -R www-data:www-data bootstrap/cache

# Si `www-data` no existe, verificar usuario de web server
# Puede ser: nobody, www-data, apache, _www, etc.
```

### 10. **Probar Localmente**

```bash
php artisan serve
# Acceder a http://localhost:8000
```

---

## 🌐 Despliegue en Plesk

### A. **Vía GitHub Remote Repository (Recomendado)**

1. **En Plesk:**
   - Ir a Sitios Web → Tu dominio
   - Git → Repositorio remoto
   - URL: `https://github.com/trexment/testBasket.git`
   - Branch: `master`
   - Deploy automático: ✓ (opcional)

2. **En Terminal (Plesk SSH):**

```bash
# Ir a la carpeta de tu subdominio
cd /var/www/vhosts/tudominio.es/oficiales.tudominio.es/

# Actualizar
git pull origin master

# Instalar dependencias
composer install
npm install

# Migraciones
php artisan migrate

# Assets
npm run build

# Permisos
chmod -R 755 storage bootstrap/cache
```

### B. **Vía File Manager + Terminal**

1. **Descargar código:**
   - Ir a https://github.com/trexment/testBasket
   - Botón verde "Code" → Download ZIP
   - Subir a Plesk via File Manager
   - Descomprimir

2. **Terminal Plesk:**

```bash
cd /var/www/vhosts/tudominio.es/oficiales.tudominio.es/
composer install
npm install --production
php artisan migrate:fresh --seed
npm run build
chmod -R 755 storage bootstrap/cache
```

### C. **Configurar Base de Datos en Plesk**

1. **MySQL:**
   - Plesk → Bases de Datos → Crear Nueva
   - Nombre: `cuestionario_baloncesto`
   - Usuario: crear nuevo
   - Contraseña: generar segura

2. **Actualizar `.env`:**
   - Editar en File Manager
   - Copiar credenciales de BD
   - `APP_URL=https://oficiales.tudominio.es`

### D. **Configurar Apache/Nginx**

**Para Nginx (Plesk automático):**
- Debería funcionar sin cambios

**Para Apache:**
- Verificar `.htaccess` en raíz
- Debería incluir rewrite rules para Laravel

### E. **Verificar Todo Funciona**

```bash
# En SSH Plesk:
php artisan migrate --env=production
php artisan storage:link
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

Acceder a `https://oficiales.tudominio.es` en navegador

---

## 🔑 Credenciales de Prueba (Después de Seed)

```
👨‍⚖️ Árbitro:
  Email: user@test.frannunez.es
  Pass:  password123

📊 Oficial:
  Email: oficial@test.frannunez.es
  Pass:  password123

🏀 Entrenador:
  Email: entrenador@test.frannunez.es
  Pass:  password123

⚙️ Admin:
  Email: admin@test.frannunez.es
  Pass:  SecureAdminPassword123!
```

---

## 🆘 Resolución de Problemas Comunes

### "Class not found" / "Composer dump-autoload"

```bash
composer dump-autoload
php artisan optimize:clear
```

### "Permission denied" en storage/

```bash
# Asegurar permisos correctos
sudo chown -R www-data:www-data storage
sudo chown -R www-data:www-data bootstrap/cache
chmod -R 755 storage bootstrap/cache
```

### "No database connection"

1. Verificar credenciales en `.env`
2. Verificar que BD existe: `CREATE DATABASE...`
3. Verificar que usuario tiene acceso
4. Tester conexión:

```bash
php artisan tinker
DB::connection()->getPdo();
# Debería retornar PDO object
```

### "Assets not loading" (CSS/JS)

```bash
npm run build
php artisan storage:link
```

### "Migrations already exist"

```bash
# Ver migraciones ejecutadas
php artisan migrate:status

# Si necesita fresh:
php artisan migrate:fresh --seed
```

---

## 📊 Nueva Base de Datos Resultante

Después de ejecutar migraciones, tendrás estas tablas principales:

- `users` - Con nuevo campo `user_type`
- `questions` - Con `question_code`, `applicable_roles`, `order`
- `test_attempts` - Tests completados
- `test_answers` - Respuestas de usuarios

Total de campos nuevos: 4
Total de preguntas por seed: 40+

---

## ✅ Verificación Post-Despliegue

Checklist de verificación:

- [ ] Aplicación carga en navegador
- [ ] Login funciona con credenciales de prueba
- [ ] Página de perfil muestra usuario y estadísticas
- [ ] Selector de tipo de usuario en crear test
- [ ] Slider de cantidad de preguntas funciona
- [ ] Checkboxes de dificultad muestran disponibilidad
- [ ] Test comienza y muestra preguntas correctamente
- [ ] Resultados se guardan y muestran en historial
- [ ] Admin puede crear preguntas con nuevo código
- [ ] Imágenes se suben correctamente (si se adjunta)

---

## 🔄 Actualización Futura

Si hay actualizaciones:

```bash
git pull origin master
composer install
npm install
php artisan migrate
npm run build
php artisan cache:clear
```

---

## 📞 Soporte

- **Documentación completa**: Ver `FEATURES_UPDATE.md`
- **GitHub**: https://github.com/trexment/testBasket
- **README**: Ver `README.md` para detalles técnicos

---

**Última actualización**: Mayo 2026  
**Versión**: 2.0.0  
**Estado**: ✅ Listo para producción

¡Feliz despliegue! 🚀
