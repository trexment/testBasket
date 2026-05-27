# 🏀 Cuestionario Baloncesto FEB

Aplicación web completa para realizar tests de formación basados en el reglamento FEB de baloncesto. Dirigida a árbitros y oficiales de mesa.

## ✨ Características

- ✅ Más de 25 preguntas basadas en reglamento FEB oficial
- ✅ Tests personalizables (cantidad, categoría, dificultad)
- ✅ Cronómetro por pregunta (configurable)
- ✅ Explicaciones detalladas con referencias a artículos
- ✅ Historial de resultados y estadísticas
- ✅ Panel de administración para gestionar preguntas
- ✅ Interfaz responsive (móvil, tablet, desktop)
- ✅ Autenticación segura (JWT + sesiones)
- ✅ Protección contra ataques comunes (SQL injection, XSS, CSRF, rate limiting)

## 🛠️ Requisitos

- **PHP:** 8.2 o superior
- **Composer:** Última versión
- **MySQL/MariaDB:** 5.7 o superior
- **Node.js:** 16.0 o superior (para compilar assets)
- **NPM/Yarn:** Última versión

## 📦 Instalación Local

### 1. Clonar el repositorio

```bash
git clone <url-del-repo> cuestionario-baloncesto
cd cuestionario-baloncesto
```

### 2. Instalar dependencias PHP

```bash
composer install
```

### 3. Configurar variables de entorno

```bash
cp .env.example .env
```

Editar `.env` con tus valores:

```env
APP_NAME="Cuestionario Baloncesto FEB"
APP_URL=http://test.frannunez.es (local) o http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cuestionario_baloncesto
DB_USERNAME=root
DB_PASSWORD=tucontraseña

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io (o tu SMTP)
MAIL_PORT=587
MAIL_USERNAME=tu_username
MAIL_PASSWORD=tu_password
MAIL_FROM_ADDRESS=noreply@test.frannunez.es
```

### 4. Generar clave de aplicación

```bash
php artisan key:generate
```

### 5. Crear base de datos

```sql
CREATE DATABASE cuestionario_baloncesto CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 6. Ejecutar migraciones y seeders

```bash
php artisan migrate --seed
```

Esto creará las tablas y cargará:
- **Usuarios:** admin@test.frannunez.es / SecureAdminPassword123! (cambiar en producción)
- **Preguntas:** 25 preguntas de ejemplo del reglamento FEB

### 7. Instalar dependencias de Node.js

```bash
npm install
```

### 8. Compilar assets

**Desarrollo:**
```bash
npm run dev
```

**Producción:**
```bash
npm run build
```

### 9. Crear enlace simbólico para storage

```bash
php artisan storage:link
```

### 10. Ejecutar servidor de desarrollo

```bash
php artisan serve
```

La aplicación estará disponible en: `http://localhost:8000`

---

## 🚀 Despliegue en Producción

### Opción 1: VPS con Plesk + Laravel Toolkit

#### Requisitos previos
- VPS con Plesk instalado
- Dominio apuntando al VPS
- Acceso FTP/SSH

#### Pasos

1. **En Plesk:**
   - Crear un nuevo subdominio: `test.frannunez.es`
   - Asegurarse de que está asignado a la versión correcta de PHP (8.2+)

2. **Subir archivos por FTP:**
   ```
   /var/www/vhosts/frannunez.es/test/ → Todos los archivos del proyecto
   ```

3. **Configurar variables de entorno:**
   - SSH a tu servidor
   - Editar `.env` con valores de producción
   - `APP_DEBUG=false`
   - `APP_ENV=production`
   - Configurar base de datos correctamente

4. **Ejecutar migraciones:**
   ```bash
   cd /var/www/vhosts/frannunez.es/test
   php artisan migrate --force
   php artisan db:seed --force
   ```

5. **Compilar assets:**
   ```bash
   npm install
   npm run build
   ```

6. **Permisos correctos:**
   ```bash
   chmod -R 755 storage
   chmod -R 755 bootstrap/cache
   chmod 644 .env
   ```

7. **Configurar SSL:**
   - Usar Let's Encrypt a través de Plesk
   - Forzar HTTPS en `.env` o en Plesk

8. **Crear cron job para limpiar sesiones (Plesk):**
   ```
   0 3 * * * php /var/www/vhosts/frannunez.es/test/artisan schedule:run >> /dev/null 2>&1
   ```

---

### Opción 2: Railway.app o Render (Recomendado para desarrollo/pruebas)

#### Railway.app

1. Conectar repositorio GitHub
2. Crear servicio PostgreSQL
3. Variables de entorno:
   ```
   APP_ENV=production
   APP_KEY=(generar con php artisan key:generate)
   DB_CONNECTION=pgsql
   DB_HOST=${{ Postgres.PGHOST }}
   DB_DATABASE=${{ Postgres.PGDATABASE }}
   DB_USERNAME=${{ Postgres.PGUSER }}
   DB_PASSWORD=${{ Postgres.PGPASSWORD }}
   ```
4. Deploy automático

#### Render

1. Conectar GitHub
2. Crear Web Service + PostgreSQL
3. Build command: `composer install && npm install && npm run build`
4. Start command: `php artisan serve --host=0.0.0.0`

---

### Opción 3: Docker

#### Dockerfile

```dockerfile
FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev \
    mysql-client git curl npm \
    && docker-php-ext-install pdo pdo_mysql gd

WORKDIR /var/www/html

COPY . .

RUN composer install --no-dev --optimize-autoloader
RUN npm install && npm run build
RUN php artisan config:cache
RUN php artisan route:cache

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0"]
```

#### docker-compose.yml

```yaml
version: '3.8'
services:
  app:
    build: .
    ports:
      - "8000:8000"
    environment:
      DB_HOST: db
      DB_DATABASE: cuestionario
      DB_USERNAME: root
      DB_PASSWORD: password
    depends_on:
      - db

  db:
    image: mysql:8.0
    environment:
      MYSQL_ROOT_PASSWORD: password
      MYSQL_DATABASE: cuestionario
    volumes:
      - dbdata:/var/lib/mysql

volumes:
  dbdata:
```

---

## 🔐 Seguridad

La aplicación incluye protecciones contra:

- **SQL Injection:** Laravel Eloquent + Validación
- **XSS:** Escapado de salidas + Laravel Blade
- **CSRF:** Tokens CSRF en todos los formularios
- **Rate Limiting:** Por IP y usuario
- **Autenticación:** Hash bcrypt, sesiones seguras
- **Contraseñas:** Hashing con bcrypt, validación fuerte

### Checklist de seguridad en producción:

- [ ] Cambiar contraseña admin en `.env`
- [ ] `APP_DEBUG=false`
- [ ] `APP_ENV=production`
- [ ] Generar nueva APP_KEY
- [ ] Configurar HTTPS/SSL
- [ ] Permisos correctos en carpetas
- [ ] Backups automáticos de BD
- [ ] Logs monitoreados
- [ ] Firewall configurado

---

## 📊 Gestión de Preguntas

### Admin Panel

Acceso: `http://test.frannunez.es/admin/questions`

Funcionalidades:
- ➕ Agregar nuevas preguntas
- ✏️ Editar existentes
- 🗑️ Eliminar
- ✅/❌ Activar/Desactivar
- 📤 Subir imágenes

### Formato de pregunta

```json
{
  "title": "Título corto de la pregunta",
  "description": "Enunciado completo",
  "option_a": "Opción A",
  "option_b": "Opción B",
  "option_c": "Opción C",
  "option_d": "Opción D",
  "correct_answer": "C",
  "explanation": "Explicación detallada por qué es C",
  "category": "arbitro" | "oficial_mesa",
  "difficulty": "baja" | "media" | "alta",
  "reference": "Art. 29 - Regla de 8 segundos",
  "image": null | "url/path"
}
```

---

## 🧪 Testing

Ejecutar tests:

```bash
php artisan test
```

---

## 📋 Estructura del Proyecto

```
cuestionario-baloncesto/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php
│   │   │   ├── TestController.php
│   │   │   └── QuestionController.php
│   │   └── Middleware/
│   │       └── IsAdmin.php
│   └── Models/
│       ├── User.php
│       ├── Question.php
│       ├── TestAttempt.php
│       └── TestAnswer.php
├── database/
│   ├── migrations/
│   └── seeders/
│       ├── DatabaseSeeder.php
│       ├── UserSeeder.php
│       └── QuestionSeeder.php
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   ├── auth/
│   │   ├── test/
│   │   └── admin/
│   ├── css/
│   └── js/
├── routes/
│   └── web.php
├── config/
├── storage/
└── public/
```

---

## 🐛 Troubleshooting

### Error: "Base de datos no encontrada"
```bash
# Crear base de datos
mysql -u root -p
CREATE DATABASE cuestionario_baloncesto CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### Error: "Permission denied storage"
```bash
chmod -R 755 storage bootstrap/cache
```

### Error: "CORS / Token mismatch"
- Verificar que `.env` tiene `APP_URL` correcto
- Limpiar caché: `php artisan cache:clear`

### Assets no se cargan
```bash
npm run build
php artisan storage:link
```

---

## 📱 Dispositivos soportados

- ✅ Desktop (1920px+)
- ✅ Tablet (768px - 1024px)
- ✅ Móvil (320px - 767px)

---

## 📞 Soporte

Para problemas o sugerencias:
- Email: admin@frannunez.es
- GitHub Issues: [Link al repo]

---

## 📄 Licencia

MIT License - Libre para uso y modificación

---

## 🙏 Créditos

- **Reglamento FEB:** [Federación Española de Baloncesto](https://www.feb.es/)
- **Framework:** Laravel 11
- **UI:** Tailwind CSS
- **Desarrollador:** Tu nombre aquí

---

**Última actualización:** Mayo 2024  
**Versión:** 1.0.0
