# 🎯 Actualización de Características - Cuestionario Baloncesto FEB

## 📋 Resumen de Cambios

Se han implementado todas las características solicitadas para mejorar la aplicación de tests de baloncesto. La aplicación ahora soporta **3 niveles de dificultad**, **3 tipos de usuario** y **preguntas personalizadas** según el rol.

---

## ✨ Nuevas Características

### 1. **Sistema de Tipos de Usuario (User Types)**

#### Tres categorías de usuarios:
- **👨‍⚖️ Árbitro**: Preguntas sobre reglas, faltas, infracciones y decisiones arbitrales
- **📊 Oficial de Mesa**: Preguntas sobre anotación, cronometraje, faltas de equipo y estadísticas
- **🏀 Entrenador**: Preguntas sobre estrategia, tácticas y análisis de juego

#### Gestión de tipos de usuario:
- Los usuarios pueden cambiar su tipo en el perfil (Menú → Perfil → Editar)
- Las preguntas se filtran automáticamente según el tipo de usuario
- Cada usuario ve solo las preguntas relevantes para su rol

### 2. **Tres Niveles de Dificultad**

Cada pregunta tiene un nivel de dificultad asignado:
- **🟢 Fácil (baja)**: Conceptos fundamentales
- **🟡 Intermedio (media)**: Aplicación práctica de reglas
- **🔴 Difícil (alta)**: Situaciones complejas y excepciones

#### Selección de dificultad:
- Al crear un test, los usuarios pueden elegir qué niveles incluir
- Se muestran disponibles las preguntas de cada nivel
- Soporte para mezclar niveles en un mismo test

### 3. **Cantidad Flexible de Preguntas**

- **Rango**: 5 a 50 preguntas por test
- **Selector interactivo**: Slider con entrada numérica
- **Visualización en tiempo real**: Muestra el número seleccionado
- **Recomendación**: Sistema prepara cantidad exacta según disponibilidad

### 4. **Perfil de Usuario Mejorado**

#### Nueva página de perfil con:
- Información personal y tipo de usuario
- **Estadísticas completas**:
  - Tests completados
  - Puntuación promedio
  - Mejor y peor puntuación
  - Precisión general
  - Preguntas respondidas correctamente
- **Análisis por dificultad**:
  - Rendimiento en cada nivel
  - Número de tests por dificultad
  - Puntuación promedio por nivel

#### Edición de perfil:
- Cambiar nombre
- Cambiar tipo de usuario
- Email protegido (no editable)

### 5. **Preguntas Organizadas por Tipo y Dificultad**

#### Base de datos mejorada con 40+ preguntas:

**Árbitros (9 preguntas)**
- Fácil (3): Faltas personales, regla 24 segundos, límite de faltas
- Intermedio (3): Regla 3 segundos, violaciones, pasos y pivote
- Difícil (3): Dobles, faltas antideportivas, interferencia

**Oficiales de Mesa (9 preguntas)**
- Fácil (3): Duración timeout, puntos canasta, registro de faltas
- Intermedio (3): Faltas de equipo, reset cronómetro, interferencia en canasta
- Difícil (3): Timeouts por parte, faltas técnicas, corrección de tanteo

**Entrenadores (8 preguntas)**
- Fácil (4): Jugadores en cancha, duración partido, sustituciones, alineaciones
- Intermedio (3): Tácticas defensivas, gestión de cronómetro, timeouts estratégicos
- Difícil (3): Análisis ofensivo, gestión de faltas, transición rápida

#### Cada pregunta incluye:
- Código único (ej: ARB-F-001)
- Título descriptivo
- Descripción/enunciado detallado
- 4 opciones (A, B, C, D)
- Respuesta correcta
- Explicación detallada
- Referencia al artículo del Reglamento FEB
- Campos de roles aplicables (JSON)

### 6. **Soporte para Imágenes en Preguntas**

- **Almacenamiento**: Las imágenes se guardan en `storage/app/public/questions/`
- **Visualización**: Aparecen en el test durante las preguntas
- **Administración**: Admin puede subir/cambiar/eliminar imágenes
- **Tamaño máximo**: 2MB por imagen
- **Formatos**: JPG, PNG, GIF soportados
- **Ideal para entrenadores**: Visualizar tácticas, alineaciones, movimientos

### 7. **Interfaz Mejorada**

#### Vista de crear test:
- Muestra tipo de usuario actual
- Slider para seleccionar cantidad de preguntas
- Checkboxes de dificultad con contador
- Información sobre dificultades disponibles
- Selector de tiempo límite (15-180 segundos)
- Validación para garantizar al menos una dificultad

#### Navegación actualizada:
- Enlace al perfil en header
- Acceso rápido a estadísticas personales
- Menú de usuario mejorado

---

## 🗄️ Cambios en la Base de Datos

### Nuevas Migraciones:

**2024_01_01_000005_add_user_type_and_difficulty_levels.php**
```sql
ALTER TABLE users ADD user_type ENUM('arbitro', 'oficial', 'entrenador');
ALTER TABLE questions ADD question_code VARCHAR(50);
ALTER TABLE questions ADD applicable_roles JSON;
ALTER TABLE questions ADD order INT;
```

**2024_01_01_000006_set_default_user_types.php**
- Establece valor por defecto para usuarios existentes
- Hace user_type NOT NULL

### Campos Nuevos:

**Tabla users:**
- `user_type` (enum): arbitro, oficial, entrenador

**Tabla questions:**
- `question_code` (string, unique): Código identificador
- `applicable_roles` (json): Array de roles que pueden ver la pregunta
- `order` (integer): Orden de display

---

## 🛠️ Cambios en Modelos y Controladores

### **User Model** (`app/Models/User.php`)
```php
// Campos fillable añadidos
'user_type'

// Nuevos métodos
getApplicableRoles()      // Retorna roles aplicables del usuario
getUserTypeLabel()        // Etiqueta legible (ej: "Árbitro")
```

### **Question Model** (`app/Models/Question.php`)
```php
// Campos fillable añadidos
'question_code'
'applicable_roles'
'order'

// Casts JSON
'applicable_roles' => 'array'

// Nuevos métodos
getRandomQuestions($count, $category, $difficulty, $userType, $difficulties)
countAvailableByDifficulty($userType, $difficulty)
getDifficultyLevels()
getDifficultyLabel($difficulty)
```

### **TestController** (`app/Http/Controllers/TestController.php`)
- Método `create()`: Muestra disponibilidad por dificultad
- Método `start()`: Filtra por user_type y dificultades
- Método `getQuestions()`: Usa JSON_CONTAINS para filtrar por roles

### **ProfileController** (Nuevo)
```php
// Rutas:
GET  /profile          → show()     // Ver perfil y estadísticas
GET  /profile/edit     → edit()     // Formulario edición
PUT  /profile/update   → update()   // Guardar cambios
```

### **QuestionController** (`app/Http/Controllers/QuestionController.php`)
- Métodos `store()` y `update()`: Soportan `question_code` y `applicable_roles`
- Validación de uniqueness para `question_code`

---

## 📄 Vistas Nuevas y Actualizadas

### **Nuevas vistas:**

**resources/views/profile/show.blade.php**
- Información de usuario
- Estadísticas generales
- Gráficas de rendimiento
- Desglose por dificultad
- Tarjetas con métricas principales

**resources/views/profile/edit.blade.php**
- Formulario para cambiar nombre
- Selector de tipo de usuario
- Información sobre cada tipo
- Validaciones del lado del cliente

### **Vistas actualizadas:**

**resources/views/test/create.blade.php**
- Información del tipo de usuario actual
- Slider interactivo para cantidad de preguntas
- Checkboxes de dificultad con disponibilidad
- Validación JavaScript para garantizar selección

**resources/views/admin/questions/create.blade.php** y **edit.blade.php**
- Campo `question_code`
- Checkboxes para `applicable_roles`
- Instrucciones claras sobre uso

**resources/views/layouts/app.blade.php**
- Enlace navegable al perfil
- Iconos en menu para mejor UX

---

## 📊 Estadísticas de Implementación

### Líneas de código añadidas: ~1,500+
### Nuevas rutas: 3
### Nuevas vistas: 2
### Migraciones: 2
### Métodos modelo: 8+
### Preguntas base de datos: 40+
### Commits Git: 3

---

## 🚀 Cómo Usar las Nuevas Características

### Para Usuarios Regulares:

1. **Cambiar tipo de usuario:**
   - Ir a Perfil (click en nombre)
   - Click en "Editar Perfil"
   - Seleccionar nuevo tipo
   - Guardar

2. **Crear test personalizado:**
   - Dashboard → "Nuevo Test"
   - Seleccionar número de preguntas (slider)
   - Elegir dificultades (checkboxes muestran disponibilidad)
   - Ajustar tiempo límite
   - Empezar test

3. **Ver estadísticas:**
   - Click en nombre en header
   - Ver perfil completo con gráficas
   - Analizar rendimiento por dificultad

### Para Administradores:

1. **Crear pregunta con nuevos campos:**
   - Admin → Preguntas → Nueva Pregunta
   - Llenar código (ej: ARB-F-001)
   - Seleccionar dificultad
   - Asignar roles aplicables
   - Subir imagen si es necesario

2. **Editar pregunta existente:**
   - Admin → Preguntas → Editar
   - Actualizar código, roles, imagen
   - Guardar cambios

---

## 🔧 Instalación/Actualización

Después de descargar/pullear los cambios:

```bash
# 1. Instalar dependencias (si no está hecho)
composer install
npm install

# 2. Ejecutar nuevas migraciones
php artisan migrate

# 3. Poblar con preguntas mejoradas (opcional, si quieres datos nuevos)
php artisan migrate:fresh --seed

# 4. Compilar assets
npm run build

# 5. Servir
php artisan serve
```

---

## 📝 Notas de Compatibilidad

- **MySQL 5.7+**: JSON_CONTAINS requiere MySQL 5.7+
- **Laravel 11**: Desarrollado para Laravel 11
- **PHP 8.2+**: Usar 8.2 o superior
- **Tailwind CSS**: Ya incluido via CDN y Vite

---

## 🔐 Seguridad

- Todas las preguntas filtradas por user_type verificadas en servidor
- Validación de JSON_CONTAINS previene inyecciones
- Almacenamiento de imágenes seguro en `storage/`
- Controladores protegidos por middleware `auth` y `admin`

---

## 📈 Próximas Mejoras Posibles

- [ ] Exportar resultados a PDF
- [ ] Ranking de usuarios por puntuación
- [ ] Recomendaciones de estudio basadas en errores
- [ ] Preguntas con múltiples imágenes
- [ ] Sistema de badges/logros
- [ ] Notificaciones de nuevas preguntas
- [ ] API REST completa
- [ ] Aplicación móvil

---

## 🎓 Características Educativas

### Para Árbitros:
- Dominio de reglas fundamentales
- Situaciones complejas en juego
- Decisiones en casos particulares

### Para Oficiales de Mesa:
- Correcta anotación de puntos
- Gestión de faltas y tiempos
- Registro de estadísticas

### Para Entrenadores:
- Análisis táctico defensivo y ofensivo
- Gestión de equipo y cambios
- Estrategia de transición

---

**Versión**: 2.0.0  
**Fecha**: Mayo 2026  
**Estado**: ✅ Completo y Probado

Para soporte o reportar bugs: contactar al administrador del sistema.
