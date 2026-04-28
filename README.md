# WARAS — Panel Administrativo

Sistema de gestión para la Biblioteca Digital y Fototeca de WARAS. Permite administrar libros, revistas, artículos, fotografías, autores, fotógrafos, categorías y usuarios con panel de administración completo.

---

## Requisitos previos

Asegúrate de tener instalados los siguientes programas antes de comenzar:

| Programa | Versión mínima | Descarga |
|----------|---------------|----------|
| PHP | 8.2 o superior | https://www.php.net/downloads |
| Composer | 2.x | https://getcomposer.org |
| Node.js | 18.x o superior | https://nodejs.org |
| npm | 9.x o superior | Incluido con Node.js |
| Git | cualquiera | https://git-scm.com |

> **Base de datos:** El proyecto usa **SQLite** por defecto, por lo que no necesitas instalar MySQL ni PostgreSQL para empezar. SQLite viene incluido con PHP.

### Extensiones PHP requeridas

Verifica que las siguientes extensiones estén activas en tu `php.ini`:

- `pdo_sqlite` (o `pdo_mysql` si usas MySQL)
- `mbstring`
- `openssl`
- `tokenizer`
- `xml`
- `ctype`
- `fileinfo`
- `gd` o `imagick` (para procesamiento de imágenes)

En Windows con XAMPP o Laragon estas extensiones suelen venir activadas por defecto.

---

## Instalación paso a paso

### 1. Clonar el repositorio

```bash
git clone <url-del-repositorio> waras
cd waras
```

### 2. Instalar dependencias PHP

```bash
composer install
```

### 3. Instalar dependencias de Node.js

```bash
npm install
```

### 4. Crear el archivo de entorno

```bash
cp .env.example .env
```

### 5. Generar la clave de la aplicación

```bash
php artisan key:generate
```

### 6. Configurar la base de datos

El proyecto usa **SQLite por defecto**. Solo necesitas crear el archivo:

```bash
# En Linux / macOS
touch database/database.sqlite

# En Windows (PowerShell)
New-Item -Path "database/database.sqlite" -ItemType File
```

Si prefieres usar **MySQL**, edita el archivo `.env` y cambia estas líneas:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=waras
DB_USERNAME=root
DB_PASSWORD=tu_password
```

Y crea la base de datos en MySQL antes de continuar:

```sql
CREATE DATABASE waras CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 7. Ejecutar las migraciones y seeders

Este comando crea todas las tablas **y carga los datos iniciales** (categorías reales, etiquetas, colecciones, usuarios, libros y fotografías de ejemplo):

```bash
php artisan migrate --seed
```

> Si quieres partir desde cero y borrar todo (útil en desarrollo):
> ```bash
> php artisan migrate:fresh --seed
> ```

### 8. Crear el enlace de almacenamiento

Necesario para que las imágenes subidas sean accesibles públicamente:

```bash
php artisan storage:link
```

### 9. Compilar los assets (CSS y JS)

```bash
npm run build
```

---

## Levantar el servidor de desarrollo

Una vez completada la instalación, abre **dos terminales** y ejecuta:

**Terminal 1 — Servidor PHP:**
```bash
php artisan serve
```

**Terminal 2 — Vite (recarga en caliente de CSS/JS):**
```bash
npm run dev
```

La aplicación estará disponible en: **http://localhost:8000**

---

## Credenciales por defecto

Los seeders crean los siguientes usuarios automáticamente:

| Rol | Email | Contraseña |
|-----|-------|-----------|
| Administrador Global | `admin@waras.local` | `Admin@2025` |
| Moderador Biblioteca | `biblioteca@waras.local` | `Biblioteca@2025` |
| Moderador Fototeca | `fototeca@waras.local` | `Fototeca@2025` |

> **Importante:** Cambia estas contraseñas inmediatamente en un entorno de producción.

El panel de administración está en: **http://localhost:8000/admin**

---

## Datos iniciales incluidos en los seeders

Al ejecutar `--seed` se cargan automáticamente:

**Estructura de Biblioteca:**
- 10 categorías principales (Generalidades, Filosofía, Ciencias Sociales, Literatura, Historia y Geografía, etc.)
- Subcategorías específicas de Ancash por cada categoría

**Estructura de Fototeca:**
- Árbol multi-nivel: Por Provincias → Por Ciudades → Por Barrios
- Categorías especiales: Desastres, Tradiciones, Patrimonio Arqueológico, Parque Nacional Huascarán
- 4 etiquetas fotográficas: Antes del Terremoto, Terremoto, Después del Terremoto, Siglo XXI
- 7 colecciones especiales: Familia, Paisajes, Ciudad, Sociedad y Cultura, etc.

**Contenido de ejemplo:**
- 10 libros y artículos sobre Ancash con autores y categorías asignadas
- 12 fotografías históricas de Ancash con fotógrafos y etiquetas asignadas

---

## Comandos útiles

```bash
# Limpiar caché de configuración y rutas
php artisan optimize:clear

# Ver todas las rutas registradas
php artisan route:list

# Regenerar autoload de clases
composer dump-autoload

# Recompilar assets para producción
npm run build
```

---

## Solución de problemas frecuentes

**Error: `No application encryption key has been specified`**
```bash
php artisan key:generate
```

**Error: `SQLSTATE: unable to open database file`**
Asegúrate de que el archivo SQLite existe y tiene permisos de escritura:
```bash
touch database/database.sqlite
chmod 664 database/database.sqlite   # Linux/macOS
```

**Las imágenes no se muestran**
Ejecuta el enlace de almacenamiento:
```bash
php artisan storage:link
```

**Error de permisos en `storage/` o `bootstrap/cache/`**
```bash
# Linux/macOS
chmod -R 775 storage bootstrap/cache
```

**Los cambios de CSS no se reflejan**
Asegúrate de que Vite esté corriendo en desarrollo (`npm run dev`) o recompila:
```bash
npm run build
```

---

## Estructura de módulos

```
Panel Admin (/admin)
├── Biblioteca
│   ├── Libros
│   ├── Revistas
│   ├── Autores
│   ├── Editoriales
│   ├── Categorías
│   ├── Subcategorías
│   ├── Descriptores
│   └── Colecciones Especiales
├── Fototeca
│   ├── Fotografías
│   ├── Fotógrafos
│   ├── Categorías
│   ├── Subcategorías
│   └── Subniveles
└── Configuración
    ├── Usuarios y Roles
    └── Configurar Web
```
