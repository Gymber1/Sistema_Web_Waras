# Panel de Administración — WARAS
> Documento de referencia: estructura, archivos, rutas y lógica del panel admin.

---

## Índice
1. [Visión General](#1-visión-general)
2. [Acceso y Autenticación](#2-acceso-y-autenticación)
3. [Layout y Diseño Base](#3-layout-y-diseño-base)
4. [Estructura de Rutas](#4-estructura-de-rutas)
5. [Módulo: Dashboard General](#5-módulo-dashboard-general)
6. [Módulo: Biblioteca](#6-módulo-biblioteca)
7. [Módulo: Fototeca](#7-módulo-fototeca)
8. [Módulo: Configuración Web](#8-módulo-configuración-web)
9. [Módulo: Usuarios y Roles](#9-módulo-usuarios-y-roles)
10. [Modelos de Base de Datos](#10-modelos-de-base-de-datos)
11. [Middleware y Gates](#11-middleware-y-gates)
12. [Inventario de Archivos](#12-inventario-de-archivos)

---

## 1. Visión General

El panel está construido en **Laravel 12** con **Blade** como motor de plantillas y **Tailwind CSS** (via CDN) + un archivo `admin.css` personalizado para estilos específicos.

**URL base:** `/admin`  
**Stack de diseño:** Dark sidebar (`#0b1120`) + contenido blanco. Sin framework JS frontend — todo es Blade + vanilla JS.

### Niveles de acceso
| Rol | Acceso |
|-----|--------|
| `is_admin_global = true` | Todo el panel sin restricciones |
| Moderador de módulo | Solo el módulo asignado (Biblioteca o Fototeca) |
| Usuario sin rol admin | Sin acceso — redirige al portal público |

---

## 2. Acceso y Autenticación

### Middleware aplicado
```
auth                          → usuario autenticado (Laravel Breeze)
can:access-admin              → admin global OR moderador de algún módulo
can:admin-only                → solo admin global (web-config, usuarios)
module.access:biblioteca      → admin global OR moderador de biblioteca
module.access:fototeca        → admin global OR moderador de fototeca
```

### Archivos de autorización
| Archivo | Función |
|---------|---------|
| `app/Http/Middleware/IsAdminOrModerator.php` | Verifica que el usuario sea admin global o moderador de al menos un módulo |
| `app/Http/Middleware/EnsureModuleAccess.php` | Parametrizado: comprueba acceso a un módulo específico, aborta 403 si no |
| `app/Providers/AppServiceProvider.php` | Define los gates `access-admin` y `admin-only` |

### Gates definidos en AppServiceProvider
```php
// Acceso general al panel
Gate::define('access-admin', function (User $user) {
    return $user->is_admin_global || $user->modules()->exists();
});

// Solo admin global (web-config, usuarios)
Gate::define('admin-only', function (User $user) {
    return $user->is_admin_global === true;
});
```

---

## 3. Layout y Diseño Base

### Archivo principal
`resources/views/layouts/admin.blade.php`

### Estructura HTML del layout
```
<body>
├── #sidebar-overlay          → overlay oscuro en móvil al abrir sidebar
└── .flex.h-screen
    ├── <aside #sidebar>       → sidebar fijo 288px, dark (#0b1120)
    │   ├── Logo WARAS + "Admin Portal"
    │   ├── nav (overflow-y-auto)
    │   │   ├── Dashboard General
    │   │   ├── Módulos Operativos
    │   │   │   ├── <details> Biblioteca   (accordion, visible si tiene acceso)
    │   │   │   └── <details> Fototeca     (accordion, visible si tiene acceso)
    │   │   ├── Próximamente (disabled: Musicoteca, Pinacoteca, Efemeridades, KOHA)
    │   │   └── Gestión del Sistema
    │   │       ├── Usuarios y Roles       (solo admin global)
    │   │       └── Configurar Web         (solo admin global)
    │   └── User Profile bar   → avatar inicial + nombre + rol
    └── .flex-1 (contenido)
        ├── <header>           → topbar 80px, blanco, breadcrumb + sección + botones
        └── <main>             → @yield('content') con scroll propio
```

### Slots del layout
```blade
@yield('title')       → <title> de la página
@yield('section')     → breadcrumb en el topbar ("Biblioteca > Libros")
@yield('content')     → contenido principal de la vista
```

### Topbar (header)
- Botón hamburger (solo móvil)
- Breadcrumb: `WARAS Panel › @yield('section')`
- Botón "Ir al Portal" → enlace al portal público
- Botón "Cerrar Sesión" → `POST /logout`

### Sidebar — estado activo
Usa `request()->routeIs('admin.xxx.*')` en Blade para aplicar la clase `bg-indigo-600 text-white` al enlace activo. Los accordions `<details>` se abren automáticamente con el atributo `open` cuando la ruta coincide.

### CSS del admin
| Archivo | Contenido |
|---------|-----------|
| `resources/css/admin.css` | Scrollbar personalizado (`.custom-scrollbar`), utilidades adicionales |
| Tailwind CDN | Clases utilitarias en todas las vistas |

---

## 4. Estructura de Rutas

`routes/web.php` — grupo admin (líneas ~59–213):

```php
Route::middleware('auth')->group(function () {
    Route::middleware('can:access-admin')
         ->prefix('admin')
         ->name('admin.')
         ->group(function () {

        // Dashboard
        Route::get('/', DashboardController::class)->name('dashboard');

        // ── BIBLIOTECA ──────────────────────────────────────────────
        Route::prefix('biblioteca')->name('biblioteca.')
             ->middleware('module.access:biblioteca')->group(function () {

            // Libros
            GET    /books                → admin.biblioteca.books
            GET    /books/create         → admin.biblioteca.books.create
            POST   /books                → admin.biblioteca.books.store
            GET    /books/{book}/edit    → admin.biblioteca.books.edit
            PUT    /books/{book}         → admin.biblioteca.books.update
            DELETE /books/{book}         → admin.biblioteca.books.destroy

            // Autores
            GET    /authors              → admin.biblioteca.authors
            GET    /authors/create       → admin.biblioteca.authors.create
            POST   /authors              → admin.biblioteca.authors.store
            GET    /authors/{author}/edit → admin.biblioteca.authors.edit
            PUT    /authors/{author}     → admin.biblioteca.authors.update
            DELETE /authors/{author}     → admin.biblioteca.authors.destroy

            // Editoriales
            GET    /publishers           → admin.biblioteca.publishers
            GET    /publishers/create    → admin.biblioteca.publishers.create
            POST   /publishers           → admin.biblioteca.publishers.store
            GET    /publishers/{pub}/edit → admin.biblioteca.publishers.edit
            PUT    /publishers/{pub}     → admin.biblioteca.publishers.update
            DELETE /publishers/{pub}     → admin.biblioteca.publishers.destroy

            // Categorías
            GET    /categories           → admin.biblioteca.categories
            GET    /categories/create    → admin.biblioteca.categories.create
            POST   /categories           → admin.biblioteca.categories.store
            GET    /categories/{cat}/edit → admin.biblioteca.categories.edit
            PUT    /categories/{cat}     → admin.biblioteca.categories.update
            DELETE /categories/{cat}     → admin.biblioteca.categories.destroy

            // Subcategorías
            GET    /subcategories        → admin.biblioteca.subcategories
            [mismos verbos CRUD]

            // Revistas
            GET    /magazines            → admin.biblioteca.magazines
            [mismos verbos CRUD]

            // Descriptores
            GET    /descriptors          → admin.biblioteca.descriptors
            POST   /descriptors          → admin.biblioteca.descriptors.store
            DELETE /descriptors/{desc}   → admin.biblioteca.descriptors.destroy

            // Colecciones Especiales
            GET    /specials             → admin.biblioteca.specials
            GET    /specials/create      → admin.biblioteca.specials.create
            POST   /specials             → admin.biblioteca.specials.store
            GET    /specials/{sp}/edit   → admin.biblioteca.specials.edit
            PUT    /specials/{sp}        → admin.biblioteca.specials.update
            DELETE /specials/{sp}        → admin.biblioteca.specials.destroy
            GET    /specials/assign-books → admin.biblioteca.specials.assign-books
            POST   /specials/assign-books → admin.biblioteca.specials.assign-books.store
        });

        // ── FOTOTECA ────────────────────────────────────────────────
        Route::prefix('fototeca')->name('fototeca.')
             ->middleware('module.access:fototeca')->group(function () {

            // Fotografías
            GET    /photos               → admin.fototeca.photos
            GET    /photos/create        → admin.fototeca.photos.create
            POST   /photos               → admin.fototeca.photos.store
            GET    /photos/{photo}/edit  → admin.fototeca.photos.edit
            PUT    /photos/{photo}       → admin.fototeca.photos.update
            DELETE /photos/{photo}       → admin.fototeca.photos.destroy

            // Fotógrafos
            GET    /photographers        → admin.fototeca.photographers
            [mismos verbos CRUD]

            // Categorías (Nivel 1)
            GET    /categories           → admin.fototeca.categories
            [mismos verbos CRUD]

            // SubCategorías (Nivel 2)
            GET    /subcategories        → admin.fototeca.subcategories
            [mismos verbos CRUD]

            // SubNiveles (Nivel 3)
            GET    /sublevels            → admin.fototeca.sublevels
            [mismos verbos CRUD]

            // Etiquetas
            GET    /tags                 → admin.fototeca.tags
            POST   /tags                 → admin.fototeca.tags.store
            DELETE /tags/{photoTag}      → admin.fototeca.tags.destroy
        });

        // ── WEB CONFIG ──────────────────────────────────────────────
        Route::middleware('can:admin-only')
             ->prefix('web-config')->name('web-config.')->group(function () {

            GET  /                → admin.web-config.index
            POST /fondos          → admin.web-config.fondos.update
            POST /contacto        → admin.web-config.contacto.update
            POST /aportantes      → admin.web-config.aportantes.update
            POST /floating-buttons → admin.web-config.floating-buttons.update
            POST /icono           → admin.web-config.icono.update
        });

        // ── USUARIOS ────────────────────────────────────────────────
        Route::middleware('can:admin-only')
             ->prefix('usuarios')->name('usuarios.')->group(function () {

            GET    /              → admin.usuarios.index
            POST   /              → admin.usuarios.store
            GET    /{user}/edit   → admin.usuarios.edit
            PUT    /{user}        → admin.usuarios.update
            DELETE /{user}        → admin.usuarios.destroy
            POST   /{user}/reset-password → admin.usuarios.reset-password
        });
    });
});
```

---

## 5. Módulo: Dashboard General

### Archivos
| Tipo | Archivo |
|------|---------|
| Controller | `app/Http/Controllers/Admin/DashboardController.php` |
| Vista | `resources/views/admin/dashboard.blade.php` |

### Lógica del controller
Invocable (`__invoke`). Recoge estadísticas globales:
- `Photo::count()`, `Photographer::count()`
- `Book::count()`, `Author::count()`, `Publisher::count()`
- `Magazine::count()`, `Category::count()`
- `Special::count()`, `User::count()`

Pasa todo como `compact(...)` a la vista.

### Vista
Cards de estadísticas por módulo, accesos rápidos a las secciones principales.

---

## 6. Módulo: Biblioteca

### Archivos
| Tipo | Archivo |
|------|---------|
| Controller | `app/Http/Controllers/Admin/BibliotecaController.php` |
| Vista módulo | `resources/views/admin/biblioteca/index.blade.php` |

#### Libros
| Archivo | Descripción |
|---------|-------------|
| `admin/biblioteca/books/index.blade.php` | Tabla de libros con búsqueda, filtros y paginación |
| `admin/biblioteca/books/create.blade.php` | Formulario de creación: título, autores (chips), editorial, sección, categoría/subcategoría, descriptores (chips), año, portada, archivo PDF |
| `admin/biblioteca/books/edit.blade.php` | Igual que create pero precargado con datos existentes |

**Secciones disponibles para libros:** `Biblioteca Digital`, `Waras Editorial`  
**Nota:** Los libros de Waras Editorial también aparecen en Biblioteca Digital (lógica en el controller público, no en la DB).

#### Autores, Editoriales
CRUD simple: nombre + campos auxiliares. Autores tienen relación N:M con libros via pivot `book_author`.

#### Categorías y Subcategorías
Árbol de 2 niveles. Las categorías son `parent_id = null`; las subcategorías apuntan a una categoría padre.

#### Revistas (Magazines)
CRUD independiente con campos: título, ISSN, año, número, editorial, portada.

#### Descriptores
Lista simple de palabras clave. Relación N:M con libros via pivot `book_descriptor`. CRUD: agregar + eliminar (no hay edición individual).

#### Colecciones Especiales (Specials)
Colecciones temáticas. Los libros se asignan en vista dedicada (`assign.blade.php`). Se pueden reordenar.

---

## 7. Módulo: Fototeca

### Archivos
| Tipo | Archivo |
|------|---------|
| Controller | `app/Http/Controllers/Admin/FototecaController.php` |
| Vista módulo | `resources/views/admin/fototeca/index.blade.php` |

#### Fotografías
| Archivo | Descripción |
|---------|-------------|
| `admin/fototeca/photos/index.blade.php` | Tabla con miniatura, título, fotógrafo, categoría, año |
| `admin/fototeca/photos/create.blade.php` | Formulario: título, fotógrafos (chips), categoría/subcategoría/subnivel (3 niveles), **etiqueta** (select), año, ubicación, resolución, formato, proveedor, descripción, tipo fuente (local/externa/ninguna), imagen |
| `admin/fototeca/photos/edit.blade.php` | Igual que create con datos precargados |

**Tipo de fuente (`source_type`):**
- `local` → sube imagen al storage (`photos/`)
- `external` → almacena solo la URL externa
- `none` → sin imagen

**Etiqueta:** relación `BelongsTo` a `photo_tags` via columna `tag_id` (nullable). Una foto = una etiqueta máximo.

#### Fotógrafos (Photographers)
CRUD con: nombre completo, lugar/fecha nacimiento y muerte, biografía, crítica de estudios, foto de perfil.

#### Jerarquía de Categorías (3 niveles)
```
Categoría (Nivel 1)   → parent_id = null
  └── SubCategoría (Nivel 2)  → parent_id = categoría
        └── SubNivel (Nivel 3) → parent_id = subcategoría
```
Todas comparten la tabla `categories` con `type = 'fototeca'`.

#### Etiquetas (Tags)
| Archivo | Descripción |
|---------|-------------|
| `admin/fototeca/tags/index.blade.php` | Grid de chips: agregar (input + botón), listar con contador de fotos, eliminar. Sin edición individual. Búsqueda client-side. |

**Tabla:** `photo_tags` (id, name, slug)  
**Relación:** `PhotoTag hasMany Photo` via `photos.tag_id`

---

## 8. Módulo: Configuración Web

### Archivos
| Tipo | Archivo |
|------|---------|
| Controller | `app/Http/Controllers/Admin/WebConfigController.php` |
| Vista índice | `resources/views/admin/web-config/index.blade.php` |

**Solo accesible para `is_admin_global = true`.**

| Vista | Función | Clave en `site_settings` |
|-------|---------|--------------------------|
| `config-fondos.blade.php` | Fondos hero de cada módulo (Biblioteca, Fototeca, Home) | `bg_biblioteca`, `bg_fototeca`, `bg_home` |
| `config-flotantes.blade.php` | Botones flotantes (WhatsApp, Facebook, etc.) | Tabla `floating_buttons` |
| `config-contacto.blade.php` | Info de contacto del portal | `contact_*` |
| `config-aportantes.blade.php` | Texto/imagen de la sección aportantes | `aportantes_*` |
| `config-icono.blade.php` | Favicon del portal | `favicon` |

**Modelo de configuración:** `SiteSetting` — tabla clave-valor `(key, value)`. Método estático `SiteSetting::get('key')` / `SiteSetting::set('key', 'value')`.

**Botones flotantes:** Modelo `FloatingButton` con campos: `label`, `url`, `icon`, `logo`, `color`, `glow_color`, `is_active`, `order`.

---

## 9. Módulo: Usuarios y Roles

### Archivos
| Tipo | Archivo |
|------|---------|
| Controller | `app/Http/Controllers/Admin/UserAdminController.php` |
| Vista listado | `resources/views/admin/users/index.blade.php` |
| Vista edición | `resources/views/admin/users/edit.blade.php` |

**Solo accesible para `is_admin_global = true`.**

### Funcionalidades
- **Listar** usuarios con su rol y módulos asignados
- **Crear** usuario (nombre, email, password, is_admin_global)
- **Editar** usuario: cambiar nombre, email, rol, módulos accesibles
- **Eliminar** usuario (no puede eliminarse a sí mismo)
- **Reset de contraseña** vía formulario (sin email — el admin asigna la nueva contraseña directamente)

### Relación User ↔ Módulos
`User BelongsToMany Module` via pivot `module_user`.  
El método `user->canAccessModule('biblioteca')` comprueba si existe el registro pivot.

---

## 10. Modelos de Base de Datos

### Relaciones principales

```
User
  └── BelongsToMany Module (pivot: module_user)

Book
  ├── BelongsToMany Author    (pivot: book_author)
  ├── BelongsToMany Descriptor (pivot: book_descriptor)
  ├── BelongsTo Publisher
  ├── BelongsToMany Category
  └── BelongsToMany Special   (pivot: book_special, con order)

Photo
  ├── BelongsToMany Photographer (pivot: photo_photographer, con order)
  ├── BelongsToMany Category     (pivot: photo_category)
  ├── BelongsToMany Special      (pivot: photo_special)
  └── BelongsTo PhotoTag         (FK: tag_id)

PhotoTag
  └── HasMany Photo (FK: tag_id)

Photographer
  └── BelongsToMany Photo

Special
  ├── BelongsToMany Book
  └── BelongsToMany Photo

Category
  ├── BelongsTo Category (parent)
  └── HasMany Category (subcategories)
  ← campo type: 'biblioteca' | 'fototeca'
```

### Tabla `site_settings`
```
id | key (string, unique) | value (text) | created_at | updated_at
```
Usada para todas las configuraciones del portal (fondos, contacto, etc.).

---

## 11. Middleware y Gates

### Flujo de autenticación

```
Request → auth → can:access-admin → [module.access:X o can:admin-only] → Controller
```

### `EnsureModuleAccess` (parametrizado)
```php
// Registro en bootstrap/app.php o Kernel:
'module.access' => EnsureModuleAccess::class

// Uso en rutas:
->middleware('module.access:biblioteca')

// Lógica:
if ($user->is_admin_global || $user->canAccessModule($module)) → continúa
else → abort(403)
```

### `IsAdminOrModerator`
Redirige a `/` si el usuario no es `is_admin_global` ni tiene módulos asignados.

---

## 12. Inventario de Archivos

### Controllers (5 archivos)
```
app/Http/Controllers/Admin/
├── DashboardController.php       → estadísticas globales del panel
├── BibliotecaController.php      → CRUD: libros, autores, editoriales, categorías, revistas, descriptores, especiales
├── FototecaController.php        → CRUD: fotos, fotógrafos, categorías (3 niveles), etiquetas
├── UserAdminController.php       → gestión de usuarios y asignación de roles
└── WebConfigController.php       → configuración del portal (fondos, botones, contacto)
```

### Modelos (16 archivos)
```
app/Models/
├── Author.php
├── Book.php
├── Category.php          → compartida: type='biblioteca' | 'fototeca'
├── Descriptor.php
├── FloatingButton.php
├── Magazine.php
├── Module.php
├── Photo.php
├── PhotoCategory.php
├── Photographer.php
├── PhotoTag.php
├── Publisher.php
├── Review.php
├── SiteSetting.php
├── Special.php
└── User.php
```

### Middleware (2 archivos)
```
app/Http/Middleware/
├── IsAdminOrModerator.php
└── EnsureModuleAccess.php
```

### Layout (1 archivo)
```
resources/views/layouts/
└── admin.blade.php
```

### CSS (1 archivo)
```
resources/css/
└── admin.css              → scrollbar personalizado, utilidades admin
```

### Vistas — Blade (53 archivos)
```
resources/views/admin/
├── dashboard.blade.php

├── biblioteca/
│   ├── index.blade.php
│   ├── books/
│   │   ├── index.blade.php
│   │   ├── create.blade.php
│   │   └── edit.blade.php
│   ├── authors/
│   │   ├── index.blade.php
│   │   ├── create.blade.php
│   │   └── edit.blade.php
│   ├── publishers/
│   │   ├── index.blade.php
│   │   ├── create.blade.php
│   │   └── edit.blade.php
│   ├── categories/
│   │   ├── index.blade.php
│   │   ├── create.blade.php
│   │   └── edit.blade.php
│   ├── subcategories/
│   │   ├── index.blade.php
│   │   ├── create.blade.php
│   │   └── edit.blade.php
│   ├── magazines/
│   │   ├── index.blade.php
│   │   ├── create.blade.php
│   │   └── edit.blade.php
│   ├── descriptors/
│   │   └── index.blade.php
│   └── specials/
│       ├── index.blade.php
│       ├── create.blade.php
│       ├── edit.blade.php
│       ├── assign.blade.php
│       └── manage.blade.php

├── fototeca/
│   ├── index.blade.php
│   ├── photos/
│   │   ├── index.blade.php
│   │   ├── create.blade.php
│   │   └── edit.blade.php
│   ├── photographers/
│   │   ├── index.blade.php
│   │   ├── create.blade.php
│   │   └── edit.blade.php
│   ├── categories/
│   │   ├── index.blade.php
│   │   ├── create.blade.php
│   │   └── edit.blade.php
│   ├── subcategories/
│   │   ├── index.blade.php
│   │   ├── create.blade.php
│   │   └── edit.blade.php
│   ├── sublevels/
│   │   ├── index.blade.php
│   │   ├── create.blade.php
│   │   └── edit.blade.php
│   ├── tags/
│   │   └── index.blade.php
│   └── specials/
│       └── index.blade.php

├── web-config/
│   ├── index.blade.php
│   ├── config-fondos.blade.php
│   ├── config-flotantes.blade.php
│   ├── config-contacto.blade.php
│   ├── config-aportantes.blade.php
│   └── config-icono.blade.php

└── users/
    ├── index.blade.php
    └── edit.blade.php
```

---

*Generado el 2026-04-27 — Proyecto WARAS, Laravel 12*
