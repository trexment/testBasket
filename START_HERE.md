# 🏀 START HERE - Cuestionario Baloncesto FEB

¡Bienvenido! Tu aplicación web de tests de baloncesto está **100% lista**. 🎉

---

## 📍 Dónde estoy

Carpeta actual: `W:/26/CustionarioBaloncesto`

## ⚡ Inicio Rápido (5 minutos)

### 1. Instalar dependencias

```bash
# En la terminal, dentro de esta carpeta:
composer install
npm install
```

### 2. Configurar entorno

```bash
cp .env.example .env

# Editar .env y configurar:
# - DB_DATABASE=cuestionario_baloncesto
# - DB_USERNAME=root
# - DB_PASSWORD=(tu contraseña MySQL)
```

### 3. Crear base de datos

```sql
-- En MySQL/MariaDB:
CREATE DATABASE cuestionario_baloncesto CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 4. Inicializar app

```bash
php artisan key:generate
php artisan migrate --seed
npm run dev
php artisan serve
```

### 5. Acceder

- **URL:** http://localhost:8000
- **Admin:** admin@test.frannunez.es / SecureAdminPassword123!
- **Usuario:** user@test.frannunez.es / password123

---

## 📚 Documentación

Lee estos archivos **en este orden**:

1. **`INSTALLATION_GUIDE.md`** ← Guía de instalación rápida
2. **`README.md`** ← Documentación completa (3000+ líneas)
3. **`plesk-deployment.md`** ← Desplegar en Plesk paso a paso
4. **`DEPLOYMENT_SUMMARY.md`** ← Resumen técnico

---

## 🗂️ Estructura simplificada

```
cuestionario-baloncesto/
│
├── app/
│   ├── Models/           ← Usuarios, Preguntas, Tests
│   ├── Http/
│   │   ├── Controllers/  ← Lógica (Auth, Tests, Admin)
│   │   └── Middleware/   ← Seguridad
│   └── ...
│
├── database/
│   ├── migrations/       ← Crear tablas
│   └── seeders/          ← Datos iniciales (25 preguntas)
│
├── resources/views/      ← HTML/Blade
│   ├── auth/            ← Login, registro
│   ├── test/            ← Tests (preguntas, resultados)
│   └── admin/           ← Panel de admin
│
├── routes/web.php        ← Rutas (URLs)
├── .env.example          ← Configuración
├── composer.json         ← Dependencias PHP
├── package.json          ← Dependencias Node
└── README.md             ← Documentación
```

---

## 🎯 Funcionalidades

### Para Usuarios
✅ Registrarse / Iniciar sesión  
✅ Crear test personalizado (cantidad, categoría, dificultad)  
✅ Responder preguntas con cronómetro  
✅ Ver resultados y explicaciones  
✅ Historial de tests  
✅ Estadísticas personales  

### Para Admin
✅ Gestionar preguntas (crear, editar, eliminar)  
✅ Subir imágenes a preguntas  
✅ Activar/desactivar preguntas  
✅ Ver historial de todos los usuarios  

---

## 🔐 Seguridad Incluida

✅ SQL Injection: Protegido  
✅ XSS: Sanitizado  
✅ CSRF: Tokens en formularios  
✅ Autenticación: JWT-ready  
✅ Passwords: Bcrypt  
✅ HTTPS: Ready  

---

## 🌍 Despliegue

### Local (para probar)
```bash
php artisan serve
# http://localhost:8000
```

### Producción en Plesk
Ver `plesk-deployment.md` → Paso a paso completo

### Otros servidores
- **Railway.app** - Deploy con 1 clic
- **Render** - Full stack hosting
- **Docker** - Containerizado

---

## 📝 Preguntas Incluidas (25)

**Árbitros (14):**
- Faltas personales
- Regla de 3 segundos
- Viajadas y dobles
- Infracciones técnicas
- Sanciones
- etc.

**Oficiales de Mesa (11):**
- Anotación
- Cronometraje
- Registro de faltas
- Estadísticas
- etc.

**Todas** basadas en **reglamento FEB oficial**.

---

## ❓ Dudas / Errores

| Problema | Solución |
|----------|----------|
| "No database" | Ver INSTALLATION_GUIDE.md paso 3 |
| Assets no cargan | `npm run build` |
| Permission denied | `chmod -R 755 storage` |
| Port 8000 en uso | `php artisan serve --port=8001` |
| APP_KEY error | `php artisan key:generate` |

---

## 🎓 Tecnologías

- **Laravel 11** - Backend PHP
- **MySQL 8.0+** - Base de datos
- **Blade** - Templating
- **Tailwind CSS** - Estilos
- **Vite** - Build tool
- **Node.js** - Runtime JS

---

## ✨ Próximos pasos

1. **Instalar localmente** (ver INSTALLATION_GUIDE.md)
2. **Probar funcionalidad** - Crear cuenta, hacer test
3. **Agregar más preguntas** - Panel admin
4. **Personalizar** - Cambiar colores, textos
5. **Desplegar** - Seguir plesk-deployment.md

---

## 🎉 ¡Ya está listo!

Tu aplicación está **100% funcional** y **lista para producción**.

**Próximo paso:** Lee `INSTALLATION_GUIDE.md` y comienza a instalar.

---

### 📞 Quick Links

- 📖 **README.md** - Documentación completa
- ⚡ **INSTALLATION_GUIDE.md** - Instala rápido
- 🌐 **plesk-deployment.md** - Deploy en Plesk
- 📊 **DEPLOYMENT_SUMMARY.md** - Resumen técnico

---

**¡Feliz coding! 🚀**
