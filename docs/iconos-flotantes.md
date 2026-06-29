# Iconos Flotantes de Contacto — WARAS

Documentación y código completo del sistema de **botones/iconos flotantes** (WhatsApp, Yape y botones extra) del portal, junto con su **configuración en el panel admin**.

## Índice de archivos

| Capa | Archivo |
|------|---------|
| Componente público (render) | `resources/views/components/floating-buttons.blade.php` |
| Modelo | `app/Models/FloatingButton.php` |
| Migración: tabla base | `database/migrations/2026_04_27_021950_create_floating_buttons_table.php` |
| Migración: columna `logo` | `database/migrations/2026_04_27_022430_add_logo_to_floating_buttons_table.php` |
| Migración: columna `glow_color` | `database/migrations/2026_04_27_024015_add_glow_color_to_floating_buttons_table.php` |
| Seeder (WhatsApp + Yape por defecto) | `database/seeders/FloatingButtonSeeder.php` |
| Vista panel admin | `resources/views/admin/web-config/config-flotantes.blade.php` |
| Controlador panel admin | `app/Http/Controllers/Admin/WebConfigController.php` (métodos floating) |
| Rutas | `routes/web.php` (grupo `web-config`) |

### Cómo se usa
- El componente se incluye en las páginas públicas con `<x-floating-buttons />` (ya está en `home.blade.php`, vistas de fototeca, biblioteca, etc.).
- WhatsApp y Yape son **fijos** (`is_default = true`) y no se pueden eliminar; sí se pueden editar (logo, QR, número, color de brillo).
- Se pueden agregar botones extra (Facebook, etc.) desde el panel.

---

## 1. Componente público — `resources/views/components/floating-buttons.blade.php`

```blade
@php
    use App\Models\FloatingButton;
    $buttons = FloatingButton::orderBy('orden')->get();
    $waNumber = \App\Models\SiteSetting::get('whatsapp_number', '51000000000');
@endphp

<div style="position:fixed;bottom:5rem;right:1.5rem;z-index:9999;display:flex;flex-direction:column;gap:0.75rem;align-items:flex-end;">
@foreach($buttons as $i => $btn)
@php
    $isYape = $btn->slug === 'yape';
    $isWa   = $btn->slug === 'whatsapp';
    // Logo para el botón circular
    $imgSrc = $btn->logo
        ? asset('storage/' . $btn->logo)
        : ($isYape ? asset('Yape.png') : ($isWa ? asset('Whatsapp.png') : null));

    $popId  = 'fb-pop-' . $btn->id;
    $wrapId = 'fb-wrap-' . $btn->id;
    $btnId  = 'fb-btn-' . $btn->id;

    // Colores de glow desde el modelo
    $glowKey   = $btn->glow_color ?? 'indigo';
    $glowOpts  = \App\Models\FloatingButton::$GLOW_OPTIONS[$glowKey] ?? \App\Models\FloatingButton::$GLOW_OPTIONS['indigo'];
    $glow      = $glowOpts[0];
    $glowHover = $glowOpts[1];
    $headColor = $glowOpts[2];
@endphp

<div style="position:relative;" id="{{ $wrapId }}">
    {{-- Popover --}}
    <div id="{{ $popId }}"
         style="display:none;position:absolute;bottom:70px;right:0;background:white;border-radius:14px;
                box-shadow:0 20px 60px rgba(0,0,0,.2);padding:1.25rem;width:240px;text-align:center;z-index:10000;">
        <div style="font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:{{ $headColor }};margin-bottom:.75rem;">
            {{ $btn->nombre }}
        </div>

        @if($isYape || $isWa)
            {{-- QR --}}
            @if($btn->imagen)
                <img src="{{ asset('storage/' . $btn->imagen) }}" alt="QR {{ $btn->nombre }}"
                     style="width:200px;height:200px;object-fit:contain;border-radius:8px;border:1px solid #f0f0f0;">
            @else
                <div style="width:200px;height:200px;background:#f8f8f8;border-radius:8px;display:flex;
                            align-items:center;justify-content:center;border:1px dashed #d1d5db;">
                    <span style="font-size:.75rem;color:#9ca3af;">Sin QR configurado</span>
                </div>
            @endif
            @if($isWa)
                <a href="https://wa.me/{{ $waNumber }}" target="_blank" rel="noopener"
                   style="display:inline-block;margin-top:.75rem;font-size:.8rem;font-weight:700;
                          color:#128C7E;font-family:monospace;text-decoration:none;">
                    +{{ $waNumber }}
                </a>
            @endif
            @if($btn->descripcion && !$isWa)
                <div style="margin-top:.85rem;font-size:.85rem;font-weight:600;color:#222;line-height:1.5;">
                    {{ $btn->descripcion }}
                </div>
            @endif
        @else
            {{-- Botón extra --}}
            @if($btn->imagen)
                <img src="{{ asset('storage/' . $btn->imagen) }}" alt="{{ $btn->nombre }}"
                     style="width:200px;height:200px;object-fit:contain;border-radius:8px;border:1px solid #f0f0f0;">
            @endif
            @if($btn->descripcion)
                <div style="margin-top:.85rem;font-size:.85rem;font-weight:500;color:#374151;line-height:1.5;">
                    {{ $btn->descripcion }}
                </div>
            @endif
            @if($btn->link)
                <a href="{{ $btn->link }}" target="_blank" rel="noopener"
                   style="display:inline-block;margin-top:.75rem;font-size:.8rem;font-weight:700;
                          color:#4f46e5;text-decoration:none;">
                    Visitar →
                </a>
            @endif
        @endif

        <div style="position:absolute;bottom:-8px;right:20px;width:16px;height:16px;background:white;
                    transform:rotate(45deg);box-shadow:3px 3px 6px rgba(0,0,0,.08);"></div>
    </div>

    {{-- Botón circular --}}
    @if($imgSrc)
    <a href="{{ $btn->link ?? '#' }}"
       @if(!$isYape && !$isWa && $btn->link) target="_blank" rel="noopener" @endif
       id="{{ $btnId }}"
       style="display:block;width:46px;height:46px;border-radius:50%;overflow:hidden;
              box-shadow:0 0 8px {{ $glow }};transition:transform .3s,box-shadow .3s;cursor:pointer;"
       onmouseover="this.style.transform='scale(1.1)';this.style.boxShadow='0 0 14px {{ $glowHover }}'"
       onmouseout="this.style.transform='scale(1)';this.style.boxShadow='0 0 8px {{ $glow }}'"
       onclick="toggleFbPop(event,'{{ $popId }}',{{ $buttons->pluck('id')->map(fn($id)=> "'fb-pop-{$id}'")->join(',') }})">
        <img src="{{ $imgSrc }}" alt="{{ $btn->nombre }}" style="width:100%;height:100%;object-fit:cover;">
    </a>
    @endif
</div>
@endforeach
</div>

<script>
function toggleFbPop(e, showId, ...allIds) {
    e.preventDefault();
    const show = document.getElementById(showId);
    const isVisible = show.style.display === 'block';
    allIds.forEach(id => { const el = document.getElementById(id); if (el) el.style.display = 'none'; });
    show.style.display = isVisible ? 'none' : 'block';
}
document.addEventListener('click', function(e) {
    @foreach($buttons as $btn)
    (function() {
        const wrap = document.getElementById('fb-wrap-{{ $btn->id }}');
        const pop  = document.getElementById('fb-pop-{{ $btn->id }}');
        if (wrap && pop && !wrap.contains(e.target)) pop.style.display = 'none';
    })();
    @endforeach
});
</script>
```

> **Nota:** El tamaño del botón circular es `46x46px` y el brillo (`box-shadow`) es `8px` en reposo / `14px` en hover (versión reducida a pedido del cliente).

---

## 2. Modelo — `app/Models/FloatingButton.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FloatingButton extends Model
{
    protected $fillable = ['slug', 'nombre', 'descripcion', 'imagen', 'logo', 'glow_color', 'link', 'is_default', 'orden'];

    // key => [rgba normal, rgba hover, hex para popover header]
    public static array $GLOW_OPTIONS = [
        'morado'   => ['rgba(116,35,101,0.8)',  'rgba(116,35,101,1)',  '#742364'],
        'verde'    => ['rgba(37,211,102,0.8)',   'rgba(37,211,102,1)',  '#128C7E'],
        'indigo'   => ['rgba(99,102,241,0.8)',   'rgba(99,102,241,1)',  '#4f46e5'],
        'azul'     => ['rgba(59,130,246,0.8)',   'rgba(59,130,246,1)',  '#2563eb'],
        'rojo'     => ['rgba(239,68,68,0.8)',    'rgba(239,68,68,1)',   '#dc2626'],
        'naranja'  => ['rgba(249,115,22,0.8)',   'rgba(249,115,22,1)',  '#ea580c'],
        'amarillo' => ['rgba(234,179,8,0.8)',    'rgba(234,179,8,1)',   '#ca8a04'],
        'rosa'     => ['rgba(236,72,153,0.8)',   'rgba(236,72,153,1)', '#db2777'],
        'cian'     => ['rgba(6,182,212,0.8)',    'rgba(6,182,212,1)',   '#0891b2'],
        'blanco'   => ['rgba(255,255,255,0.6)',  'rgba(255,255,255,0.9)', '#64748b'],
    ];

    protected $casts = ['is_default' => 'boolean'];
}
```

---

## 3. Migraciones

### 3.1 Tabla base — `2026_04_27_021950_create_floating_buttons_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('floating_buttons', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->string('imagen')->nullable();
            $table->string('link')->nullable();
            $table->boolean('is_default')->default(false);
            $table->integer('orden')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('floating_buttons');
    }
};
```

### 3.2 Columna `logo` — `2026_04_27_022430_add_logo_to_floating_buttons_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('floating_buttons', function (Blueprint $table) {
            $table->string('logo')->nullable()->after('imagen');
        });
    }

    public function down(): void
    {
        Schema::table('floating_buttons', function (Blueprint $table) {
            $table->dropColumn('logo');
        });
    }
};
```

### 3.3 Columna `glow_color` — `2026_04_27_024015_add_glow_color_to_floating_buttons_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('floating_buttons', function (Blueprint $table) {
            $table->string('glow_color')->default('indigo')->after('logo');
        });
    }

    public function down(): void
    {
        Schema::table('floating_buttons', function (Blueprint $table) {
            $table->dropColumn('glow_color');
        });
    }
};
```

---

## 4. Seeder — `database/seeders/FloatingButtonSeeder.php`

Crea los dos botones por defecto (WhatsApp y Yape) y copia sus logos desde `public/` a `storage/app/public/floating/`.

```php
<?php

namespace Database\Seeders;

use App\Models\FloatingButton;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class FloatingButtonSeeder extends Seeder
{
    public function run(): void
    {
        $buttons = [
            [
                'slug'        => 'whatsapp',
                'nombre'      => 'WhatsApp',
                'descripcion' => '',
                'imagen'      => null,
                'logo_source' => 'Whatsapp.png',
                'glow_color'  => 'verde',
                'link'        => '',
                'is_default'  => true,
                'orden'       => 1,
            ],
            [
                'slug'        => 'yape',
                'nombre'      => 'Yape',
                'descripcion' => '',
                'imagen'      => null,
                'logo_source' => 'Yape.png',
                'glow_color'  => 'morado',
                'link'        => '',
                'is_default'  => true,
                'orden'       => 2,
            ],
        ];

        foreach ($buttons as $data) {
            $logoSource = $data['logo_source'];
            unset($data['logo_source']);

            // Copiar logo desde public/ a storage/public/floating/ si existe
            $sourcePath = public_path($logoSource);
            $destPath   = 'floating/' . $logoSource;

            if (file_exists($sourcePath) && !Storage::disk('public')->exists($destPath)) {
                Storage::disk('public')->put($destPath, file_get_contents($sourcePath));
            }

            $data['logo'] = file_exists($sourcePath) ? $destPath : null;

            $btn = FloatingButton::where('slug', $data['slug'])->first();

            if ($btn) {
                // Solo actualizar el logo si actualmente apunta al nombre plano (sin ruta)
                if ($btn->logo === $logoSource || $btn->logo === null) {
                    $btn->logo = $data['logo'];
                    $btn->save();
                }
            } else {
                FloatingButton::create($data);
            }
        }
    }
}
```

> Registra el seeder en `DatabaseSeeder::run()` con `$this->call(FloatingButtonSeeder::class);` y ejecútalo con `php artisan db:seed --class=FloatingButtonSeeder`.

---

## 5. Controlador del panel — `app/Http/Controllers/Admin/WebConfigController.php`

Métodos relacionados con los botones flotantes. Requiere los imports:
`use App\Models\FloatingButton;`, `use App\Models\SiteSetting;`, `use Illuminate\Support\Facades\Storage;`, `use Illuminate\Http\Request;`.

```php
// La vista del panel se carga con (método 'index' o el que renderiza config-flotantes):
//   $buttons = FloatingButton::orderBy('orden')->get();
//   return view('admin.web-config.config-flotantes', compact('buttons'));

// ── Actualizar botones existentes + crear botón nuevo (form principal) ──────
public function updateContact(Request $request)
{
    $request->validate([
        'buttons'                  => ['nullable', 'array'],
        'buttons.*.nombre'         => ['required', 'string', 'max:80'],
        'buttons.*.descripcion'    => ['nullable', 'string', 'max:300'],
        'buttons.*.link'           => ['nullable', 'string', 'max:300'],
        'buttons.*.glow_color'     => ['nullable', 'string'],
        'buttons.*.logo'           => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:1024'],
        'buttons.*.imagen'         => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        'whatsapp_number'       => ['nullable', 'string', 'digits_between:0,9'],
        'new_nombre'            => ['nullable', 'string', 'max:80'],
        'new_descripcion'       => ['nullable', 'string', 'max:300'],
        'new_link'              => ['nullable', 'string', 'max:300'],
        'new_logo'              => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:1024'],
        'new_imagen'            => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        'new_glow_color'        => ['nullable', 'string'],
    ]);

    // Actualizar botones existentes
    foreach ($request->input('buttons', []) as $id => $fields) {
        $btn = FloatingButton::find($id);
        if (!$btn) continue;

        $btn->nombre      = $fields['nombre'];
        $btn->descripcion = $fields['descripcion'] ?? null;
        $btn->link        = $fields['link'] ?? null;
        $btn->glow_color  = $fields['glow_color'] ?? 'indigo';

        // WhatsApp: número especial
        if ($btn->slug === 'whatsapp') {
            $number = preg_replace('/\D/', '', $request->input('whatsapp_number', ''));
            if ($number !== '') {
                if (!str_starts_with($number, '51')) $number = '51' . $number;
            }
            $btn->link        = $number ? 'https://wa.me/' . $number : $btn->link;
            $btn->descripcion = $number ?: $btn->descripcion;
            SiteSetting::set('whatsapp_number', $number ?: null);
        }

        // Logo del botón circular
        if ($request->hasFile("buttons.{$id}.logo")) {
            if ($btn->logo && Storage::disk('public')->exists($btn->logo)) {
                Storage::disk('public')->delete($btn->logo);
            }
            $btn->logo = $request->file("buttons.{$id}.logo")->store('floating', 'public');
        }

        // QR / imagen del popover
        if ($request->hasFile("buttons.{$id}.imagen")) {
            if ($btn->imagen && Storage::disk('public')->exists($btn->imagen)) {
                Storage::disk('public')->delete($btn->imagen);
            }
            $btn->imagen = $request->file("buttons.{$id}.imagen")->store('floating', 'public');
            if ($btn->slug === 'yape')     SiteSetting::set('yape_qr',     $btn->imagen);
            if ($btn->slug === 'whatsapp') SiteSetting::set('whatsapp_qr', $btn->imagen);
        }

        $btn->save();
    }

    // Nuevo botón extra
    if ($request->filled('new_nombre')) {
        $logoPath = null;
        $imgPath  = null;
        if ($request->hasFile('new_logo'))   $logoPath = $request->file('new_logo')->store('floating', 'public');
        if ($request->hasFile('new_imagen'))  $imgPath  = $request->file('new_imagen')->store('floating', 'public');
        $maxOrden = FloatingButton::max('orden') ?? 0;
        FloatingButton::create([
            'slug'        => 'extra_' . uniqid(),
            'nombre'      => $request->input('new_nombre'),
            'descripcion' => $request->input('new_descripcion'),
            'link'        => $request->input('new_link'),
            'logo'        => $logoPath,
            'imagen'      => $imgPath,
            'glow_color'  => $request->input('new_glow_color', 'indigo'),
            'is_default'  => false,
            'orden'       => $maxOrden + 1,
        ]);
    }

    return back()->with('success', 'Botones flotantes actualizados correctamente.');
}

// ── Actualizar UN botón (form individual por botón) ─────────────────────────
public function updateFloatingButton(Request $request, FloatingButton $floatingButton)
{
    $request->validate([
        'nombre'      => ['required', 'string', 'max:80'],
        'descripcion' => ['nullable', 'string', 'max:300'],
        'link'        => ['nullable', 'string', 'max:300'],
        'glow_color'  => ['nullable', 'string'],
        'logo'        => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:1024'],
        'imagen'      => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
    ]);

    $floatingButton->nombre      = $request->input('nombre');
    $floatingButton->descripcion = $request->input('descripcion');
    $floatingButton->glow_color  = $request->input('glow_color', 'indigo');

    if ($floatingButton->slug !== 'whatsapp') {
        $floatingButton->link = $request->input('link');
    }

    if ($floatingButton->slug === 'whatsapp') {
        $number = preg_replace('/\D/', '', $request->input('whatsapp_number', ''));
        if ($number !== '') {
            if (!str_starts_with($number, '51')) $number = '51' . $number;
        }
        $floatingButton->link        = $number ? 'https://wa.me/' . $number : $floatingButton->link;
        $floatingButton->descripcion = $number ?: $floatingButton->descripcion;
        SiteSetting::set('whatsapp_number', $number ?: null);
    }

    if ($request->hasFile('logo')) {
        if ($floatingButton->logo && Storage::disk('public')->exists($floatingButton->logo)) {
            Storage::disk('public')->delete($floatingButton->logo);
        }
        $floatingButton->logo = $request->file('logo')->store('floating', 'public');
    }

    if ($request->hasFile('imagen')) {
        if ($floatingButton->imagen && Storage::disk('public')->exists($floatingButton->imagen)) {
            Storage::disk('public')->delete($floatingButton->imagen);
        }
        $floatingButton->imagen = $request->file('imagen')->store('floating', 'public');
        if ($floatingButton->slug === 'yape')     SiteSetting::set('yape_qr',     $floatingButton->imagen);
        if ($floatingButton->slug === 'whatsapp') SiteSetting::set('whatsapp_qr', $floatingButton->imagen);
    }

    $floatingButton->save();
    return back()->with('success', 'Botón "' . $floatingButton->nombre . '" guardado correctamente.');
}

// ── Eliminar botón (solo no-default) ────────────────────────────────────────
public function destroyFloatingButton(FloatingButton $floatingButton)
{
    abort_if($floatingButton->is_default, 403);
    if ($floatingButton->imagen && Storage::disk('public')->exists($floatingButton->imagen)) {
        Storage::disk('public')->delete($floatingButton->imagen);
    }
    if ($floatingButton->logo && Storage::disk('public')->exists($floatingButton->logo)) {
        Storage::disk('public')->delete($floatingButton->logo);
    }
    $floatingButton->delete();
    return back()->with('success', 'Botón eliminado correctamente.');
}

// ── Quitar SOLO la imagen/QR del popover ────────────────────────────────────
public function destroyFloatingButtonImagen(FloatingButton $floatingButton)
{
    if ($floatingButton->imagen && Storage::disk('public')->exists($floatingButton->imagen)) {
        Storage::disk('public')->delete($floatingButton->imagen);
    }
    $floatingButton->imagen = null;
    $floatingButton->save();
    if ($floatingButton->slug === 'yape')     SiteSetting::set('yape_qr', null);
    if ($floatingButton->slug === 'whatsapp') SiteSetting::set('whatsapp_qr', null);
    return back()->with('success', 'Imagen eliminada correctamente.');
}

// ── Quitar SOLO el logo personalizado (vuelve al logo por defecto) ──────────
public function destroyFloatingButtonLogo(FloatingButton $floatingButton)
{
    if ($floatingButton->logo && Storage::disk('public')->exists($floatingButton->logo)) {
        Storage::disk('public')->delete($floatingButton->logo);
    }
    $floatingButton->logo = null;
    $floatingButton->save();
    return back()->with('success', 'Logo eliminado. Se usará el logo por defecto.');
}
```

---

## 6. Rutas — `routes/web.php`

Dentro del grupo admin con prefijo `web-config` (middleware `can:admin-only`):

```php
Route::middleware('can:admin-only')->prefix('web-config')->name('web-config.')->group(function () {
    // ... otras rutas de configuración web ...

    // Form principal (actualiza todos + crea nuevo)
    Route::post('/contact/update',                         [WebConfigController::class, 'updateContact'])->name('contact.update');

    // Botones flotantes (form individual y borrados)
    Route::post('/floating-btn/{floatingButton}',          [WebConfigController::class, 'updateFloatingButton'])->name('floating-btn.update');
    Route::delete('/floating-btn/{floatingButton}',        [WebConfigController::class, 'destroyFloatingButton'])->name('floating-btn.destroy');
    Route::delete('/floating-btn/{floatingButton}/imagen', [WebConfigController::class, 'destroyFloatingButtonImagen'])->name('floating-btn.imagen.destroy');
    Route::delete('/floating-btn/{floatingButton}/logo',   [WebConfigController::class, 'destroyFloatingButtonLogo'])->name('floating-btn.logo.destroy');
});
```

---

## 7. Vista del panel admin — `resources/views/admin/web-config/config-flotantes.blade.php`

```blade
@extends('layouts.admin')

@section('title', 'Iconos Flotantes — WARAS Panel')
@section('section', 'Configurar Web')

@section('content')
<div class="max-w-[960px] mx-auto">

    <div class="mb-6 flex items-start gap-4">
        <a href="{{ route('admin.web-config.index') }}"
            class="mt-0.5 p-2 rounded-lg bg-white dark:bg-dark-surface border border-slate-200 dark:border-dark-border hover:bg-slate-50 dark:hover:bg-slate-800/50 text-slate-500 dark:text-slate-400 transition-colors shadow-premium dark:shadow-premium-dark">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
        </a>
        <div>
            <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Iconos Flotantes de Contacto</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Edita los botones flotantes del portal. Yape y WhatsApp son fijos y no se pueden eliminar.</p>
        </div>
    </div>

    @if(session('success'))
    <div class="mb-5 flex items-center gap-3 px-5 py-3.5 bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 text-emerald-700 dark:text-emerald-400 rounded-xl text-sm font-medium">
        <i data-lucide="check-circle" class="w-4 h-4 shrink-0"></i>
        {{ session('success') }}
    </div>
    @endif

    @if($errors->any())
    <div class="mb-5 flex items-start gap-3 px-5 py-3.5 bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 text-red-700 dark:text-red-400 rounded-xl text-sm">
        <i data-lucide="alert-circle" class="w-4 h-4 shrink-0 mt-0.5"></i>
        <ul class="space-y-1">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    {{-- ── Botones existentes ── --}}
    <div class="space-y-5 mb-6">
    @foreach($buttons as $btn)
    @php
        $isWa   = $btn->slug === 'whatsapp';
        $isYape = $btn->slug === 'yape';
        $waNum  = $isWa ? preg_replace('/^51/', '', $btn->descripcion ?? '') : '';
        $logoSrc = $btn->logo ? asset('storage/' . $btn->logo) : ($isYape ? asset('Yape.png') : ($isWa ? asset('Whatsapp.png') : null));
        $qrSrc  = $btn->imagen ? asset('storage/' . $btn->imagen) : null;
        $glowColors  = ['morado'=>'#742364','verde'=>'#128C7E','indigo'=>'#4f46e5','azul'=>'#2563eb','rojo'=>'#dc2626','naranja'=>'#ea580c','amarillo'=>'#ca8a04','rosa'=>'#db2777','cian'=>'#0891b2','blanco'=>'#64748b'];
        $selectedGlow = old("glow_color", $btn->glow_color ?? 'indigo');
    @endphp

    <form method="POST" action="{{ route('admin.web-config.floating-btn.update', $btn) }}" enctype="multipart/form-data">
        @csrf
        <div class="bg-white dark:bg-dark-surface rounded-xl shadow-premium dark:shadow-premium-dark border border-slate-200/50 dark:border-dark-border overflow-hidden">

            <div class="px-6 py-4 border-b border-slate-100 dark:border-dark-border bg-slate-50/50 dark:bg-slate-800/20 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    @if($logoSrc)
                        <img src="{{ $logoSrc }}" alt="{{ $btn->nombre }}" class="w-9 h-9 rounded-full object-cover border border-slate-200 dark:border-slate-700">
                    @else
                        <div class="w-9 h-9 rounded-full bg-slate-200 dark:bg-slate-700 flex items-center justify-center text-slate-500 dark:text-slate-400 text-sm font-bold">{{ substr($btn->nombre,0,1) }}</div>
                    @endif
                    <div>
                        <span class="font-semibold text-slate-800 dark:text-white text-sm">{{ $btn->nombre }}</span>
                        @if($btn->is_default)
                            <span class="ml-2 text-[10px] font-medium uppercase tracking-wider bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-400 px-2 py-0.5 rounded-md">Por defecto</span>
                        @endif
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    @if(!$btn->is_default)
                    <button type="button" onclick="deleteFb('del-fb-{{ $btn->id }}')"
                            class="inline-flex items-center gap-1.5 text-xs text-red-500 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 font-medium transition-colors">
                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                        Eliminar
                    </button>
                    @endif
                    <button type="submit"
                            class="inline-flex items-center gap-1.5 bg-brand-500 hover:bg-brand-600 text-white font-medium text-xs px-4 py-2 rounded-lg transition-colors shadow-sm shadow-brand-500/30">
                        <i data-lucide="check" class="w-3.5 h-3.5"></i>
                        Guardar
                    </button>
                </div>
            </div>

            <div class="p-6 grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- Logo --}}
                <div class="flex flex-col gap-2">
                    <div>
                        <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Logo del botón</p>
                        <p class="text-xs text-slate-400 dark:text-slate-500 mt-0.5">Imagen circular que flota en el portal.</p>
                    </div>
                    <div class="border-2 border-dashed border-slate-200 dark:border-slate-700 rounded-xl p-4 flex flex-col items-center gap-2 hover:border-brand-400 dark:hover:border-brand-500 transition-colors cursor-pointer"
                         onclick="document.getElementById('logo-{{ $btn->id }}').click()">
                        <img id="prev-logo-{{ $btn->id }}" src="{{ $logoSrc ?? '' }}"
                             class="w-20 h-20 object-contain rounded-full border border-slate-200 dark:border-slate-700 {{ $logoSrc ? '' : 'hidden' }}">
                        <div id="logo-ph-{{ $btn->id }}" class="{{ $logoSrc ? 'hidden' : '' }} text-slate-400 dark:text-slate-500 text-xs text-center">
                            <i data-lucide="image" class="w-8 h-8 mx-auto mb-1 opacity-40"></i>
                            Sin logo
                        </div>
                        <span class="text-xs text-slate-400 dark:text-slate-500">Clic para cambiar</span>
                    </div>
                    <input id="logo-{{ $btn->id }}" type="file" name="logo" accept="image/*" class="hidden"
                           onchange="previewFb(this,'prev-logo-{{ $btn->id }}','logo-ph-{{ $btn->id }}')">
                    @if($btn->logo)
                    <button type="button" onclick="deleteImg('del-logo-{{ $btn->id }}')"
                            class="text-xs text-red-400 dark:text-red-500 hover:text-red-600 dark:hover:text-red-400 font-medium flex items-center justify-center gap-1 mt-1 transition-colors">
                        <i data-lucide="x" class="w-3 h-3"></i>
                        Quitar logo personalizado
                    </button>
                    @endif
                </div>

                {{-- QR/imagen --}}
                <div class="flex flex-col gap-2">
                    <div>
                        <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                            {{ ($isYape || $isWa) ? 'QR del popover' : 'Imagen del popover' }}
                        </p>
                        <p class="text-xs text-slate-400 dark:text-slate-500 mt-0.5">
                            {{ ($isYape || $isWa) ? 'Se muestra al hacer clic en el botón.' : 'Imagen que aparece en el globo de información.' }}
                        </p>
                    </div>
                    <div class="border-2 border-dashed border-slate-200 dark:border-slate-700 rounded-xl p-4 flex flex-col items-center gap-2 hover:border-brand-400 dark:hover:border-brand-500 transition-colors cursor-pointer"
                         onclick="document.getElementById('qr-{{ $btn->id }}').click()">
                        <img id="prev-qr-{{ $btn->id }}" src="{{ $qrSrc ?? '' }}"
                             class="w-24 h-24 object-contain rounded-lg {{ $qrSrc ? '' : 'hidden' }}">
                        <div id="qr-ph-{{ $btn->id }}" class="{{ $qrSrc ? 'hidden' : '' }} text-slate-400 dark:text-slate-500 text-xs text-center">
                            <i data-lucide="qr-code" class="w-8 h-8 mx-auto mb-1 opacity-40"></i>
                            Sin imagen
                        </div>
                        <span class="text-xs text-slate-400 dark:text-slate-500">Clic para cambiar</span>
                    </div>
                    <input id="qr-{{ $btn->id }}" type="file" name="imagen" accept="image/*" class="hidden"
                           onchange="previewFb(this,'prev-qr-{{ $btn->id }}','qr-ph-{{ $btn->id }}')">
                    @if($btn->imagen)
                    <button type="button" onclick="deleteImg('del-img-{{ $btn->id }}')"
                            class="text-xs text-red-400 dark:text-red-500 hover:text-red-600 dark:hover:text-red-400 font-medium flex items-center justify-center gap-1 mt-1 transition-colors">
                        <i data-lucide="x" class="w-3 h-3"></i>
                        Quitar {{ ($isYape || $isWa) ? 'QR' : 'imagen' }}
                    </button>
                    @endif
                </div>

                {{-- Campos texto --}}
                <div class="flex flex-col gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">Nombre</label>
                        <input type="text" name="nombre" value="{{ old('nombre', $btn->nombre) }}"
                               class="w-full bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg px-4 py-2.5 text-sm text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 transition-all">
                    </div>

                    @if($isWa)
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">Número de WhatsApp</label>
                        <div class="flex items-center border border-slate-300 dark:border-slate-600 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-brand-500/50">
                            <span class="px-3 py-2.5 bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-400 text-sm font-mono border-r border-slate-300 dark:border-slate-600 select-none">+51</span>
                            <input type="text" name="whatsapp_number" value="{{ $waNum }}"
                                   placeholder="987654321" maxlength="9" inputmode="numeric"
                                   oninput="this.value=this.value.replace(/\D/g,'')"
                                   class="flex-1 px-3 py-2.5 text-sm font-mono outline-none bg-white dark:bg-slate-800/50 text-slate-800 dark:text-white">
                        </div>
                        <p class="text-xs text-slate-400 dark:text-slate-500 mt-1">9 dígitos. Se guarda como <code class="bg-slate-100 dark:bg-slate-700 px-1 rounded text-slate-600 dark:text-slate-300">51xxxxxxxxx</code></p>
                    </div>
                    @else
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">Descripción del popover</label>
                        <textarea name="descripcion" rows="3"
                            class="w-full bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg px-4 py-2.5 text-sm text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 resize-none transition-all"
                        >{{ old('descripcion', $btn->descripcion) }}</textarea>
                    </div>
                    @endif

                    @if(!$isWa && !$isYape)
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">Enlace (URL)</label>
                        <input type="text" name="link" value="{{ old('link', $btn->link) }}"
                               placeholder="https://..."
                               class="w-full bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg px-4 py-2.5 text-sm text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 transition-all">
                    </div>
                    @endif

                    <div>
                        <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">Color de brillo</label>
                        <input type="hidden" name="glow_color" id="glow-val-{{ $btn->id }}" value="{{ $selectedGlow }}">
                        <div class="flex flex-wrap gap-2" id="glow-swatches-{{ $btn->id }}">
                            @foreach($glowColors as $colorKey => $colorHex)
                            <div onclick="selectGlow('{{ $btn->id }}','{{ $colorKey }}',this)"
                                 title="{{ ucfirst($colorKey) }}"
                                 data-color="{{ $colorKey }}"
                                 style="width:28px;height:28px;border-radius:50%;background:{{ $colorHex }};cursor:pointer;transition:transform .15s,box-shadow .15s;flex-shrink:0;
                                        {{ $selectedGlow === $colorKey ? 'box-shadow:0 0 0 2px #fff,0 0 0 4px #1e293b;transform:scale(1.15)' : '' }}">
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </form>
    @endforeach
    </div>

    {{-- ── Agregar nuevo botón ── --}}
    <form method="POST" action="{{ route('admin.web-config.contact.update') }}" enctype="multipart/form-data">
        @csrf
        <div class="bg-white dark:bg-dark-surface rounded-xl border-2 border-dashed border-slate-200 dark:border-dark-border overflow-hidden mb-5">
            <div class="px-6 py-4 border-b border-slate-100 dark:border-dark-border bg-slate-50/50 dark:bg-slate-800/20 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-brand-50 dark:bg-brand-500/10 rounded-lg flex items-center justify-center">
                        <i data-lucide="plus" class="w-4 h-4 text-brand-500"></i>
                    </div>
                    <h3 class="font-semibold text-slate-700 dark:text-slate-200 text-sm">Agregar nuevo botón flotante</h3>
                </div>
                <button type="submit"
                        class="inline-flex items-center gap-1.5 bg-brand-500 hover:bg-brand-600 text-white font-medium text-xs px-4 py-2 rounded-lg transition-colors shadow-sm shadow-brand-500/30">
                    <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                    Agregar botón
                </button>
            </div>
            <div class="p-6 grid grid-cols-1 lg:grid-cols-3 gap-6">

                <div class="flex flex-col gap-2">
                    <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Logo del botón</p>
                    <div class="border-2 border-dashed border-slate-200 dark:border-slate-700 rounded-xl p-4 flex flex-col items-center gap-2 hover:border-brand-400 transition-colors cursor-pointer"
                         onclick="document.getElementById('new-logo').click()">
                        <img id="prev-new-logo" src="" class="w-20 h-20 object-contain rounded-full border border-slate-200 dark:border-slate-700 hidden">
                        <div id="new-logo-ph" class="text-slate-400 dark:text-slate-500 text-xs text-center">
                            <i data-lucide="image" class="w-8 h-8 mx-auto mb-1 opacity-40"></i>
                            Sin logo
                        </div>
                        <span class="text-xs text-slate-400 dark:text-slate-500">Clic para subir</span>
                    </div>
                    <input id="new-logo" type="file" name="new_logo" accept="image/*" class="hidden"
                           onchange="previewFb(this,'prev-new-logo','new-logo-ph')">
                </div>

                <div class="flex flex-col gap-2">
                    <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Imagen del popover</p>
                    <div class="border-2 border-dashed border-slate-200 dark:border-slate-700 rounded-xl p-4 flex flex-col items-center gap-2 hover:border-brand-400 transition-colors cursor-pointer"
                         onclick="document.getElementById('new-img').click()">
                        <img id="prev-new-img" src="" class="w-24 h-24 object-contain rounded-lg hidden">
                        <div id="new-img-ph" class="text-slate-400 dark:text-slate-500 text-xs text-center">
                            <i data-lucide="qr-code" class="w-8 h-8 mx-auto mb-1 opacity-40"></i>
                            Sin imagen
                        </div>
                        <span class="text-xs text-slate-400 dark:text-slate-500">Clic para subir</span>
                    </div>
                    <input id="new-img" type="file" name="new_imagen" accept="image/*" class="hidden"
                           onchange="previewFb(this,'prev-new-img','new-img-ph')">
                </div>

                <div class="flex flex-col gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">Nombre</label>
                        <input type="text" name="new_nombre" value="{{ old('new_nombre') }}" placeholder="Ej. Facebook"
                               class="w-full bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg px-4 py-2.5 text-sm text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">Descripción</label>
                        <textarea name="new_descripcion" rows="2" placeholder="Texto del popover..."
                            class="w-full bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg px-4 py-2.5 text-sm text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 resize-none transition-all"
                        >{{ old('new_descripcion') }}</textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">Enlace (URL)</label>
                        <input type="text" name="new_link" value="{{ old('new_link') }}" placeholder="https://..."
                               class="w-full bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-600 rounded-lg px-4 py-2.5 text-sm text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">Color de brillo</label>
                        @php $newGlowColors = ['morado'=>'#742364','verde'=>'#128C7E','indigo'=>'#4f46e5','azul'=>'#2563eb','rojo'=>'#dc2626','naranja'=>'#ea580c','amarillo'=>'#ca8a04','rosa'=>'#db2777','cian'=>'#0891b2','blanco'=>'#64748b']; @endphp
                        <input type="hidden" name="new_glow_color" id="glow-val-new" value="{{ old('new_glow_color', 'indigo') }}">
                        <div class="flex flex-wrap gap-2" id="glow-swatches-new">
                            @foreach($newGlowColors as $colorKey => $colorHex)
                            <div onclick="selectGlow('new','{{ $colorKey }}',this)"
                                 title="{{ ucfirst($colorKey) }}"
                                 data-color="{{ $colorKey }}"
                                 style="width:28px;height:28px;border-radius:50%;background:{{ $colorHex }};cursor:pointer;transition:transform .15s,box-shadow .15s;flex-shrink:0;
                                        {{ old('new_glow_color','indigo') === $colorKey ? 'box-shadow:0 0 0 2px #fff,0 0 0 4px #1e293b;transform:scale(1.15)' : '' }}">
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

{{-- Forms ocultos eliminar botón --}}
@foreach($buttons as $btn)
@if(!$btn->is_default)
<form id="del-fb-{{ $btn->id }}" method="POST" action="{{ route('admin.web-config.floating-btn.destroy', $btn) }}" style="display:none;">
    @csrf @method('DELETE')
</form>
@endif
@endforeach

{{-- Forms ocultos eliminar imagen/logo --}}
@foreach($buttons as $btn)
<form id="del-img-{{ $btn->id }}" method="POST" action="{{ route('admin.web-config.floating-btn.imagen.destroy', $btn) }}" style="display:none;">
    @csrf @method('DELETE')
</form>
<form id="del-logo-{{ $btn->id }}" method="POST" action="{{ route('admin.web-config.floating-btn.logo.destroy', $btn) }}" style="display:none;">
    @csrf @method('DELETE')
</form>
@endforeach

<script>
function deleteFb(formId) {
    if (!confirm('¿Eliminar este botón flotante?')) return;
    document.getElementById(formId).submit();
}
function deleteImg(formId) {
    if (!confirm('¿Eliminar esta imagen?')) return;
    document.getElementById(formId).submit();
}
function selectGlow(btnId, colorKey, el) {
    document.getElementById('glow-val-' + btnId).value = colorKey;
    document.getElementById('glow-swatches-' + btnId).querySelectorAll('div[data-color]').forEach(s => {
        s.style.boxShadow = '';
        s.style.transform = '';
    });
    el.style.boxShadow = '0 0 0 2px #fff, 0 0 0 4px #1e293b';
    el.style.transform = 'scale(1.15)';
}
function previewFb(input, previewId, placeholderId) {
    if (!input.files || !input.files[0]) return;
    const reader = new FileReader();
    reader.onload = e => {
        const img = document.getElementById(previewId);
        img.src = e.target.result;
        img.classList.remove('hidden');
        const ph = document.getElementById(placeholderId);
        if (ph) ph.classList.add('hidden');
    };
    reader.readAsDataURL(input.files[0]);
}
</script>
@endsection
```

---

## 8. Resumen de funcionamiento

1. **Almacenamiento:** cada botón es una fila en `floating_buttons`. WhatsApp y Yape son `is_default = true` (no se borran).
2. **Imágenes:** se guardan en `storage/app/public/floating/` (requiere `php artisan storage:link`). El `logo` es el círculo flotante; la `imagen` es el QR/popover.
3. **Color de brillo (`glow_color`):** clave que mapea a `FloatingButton::$GLOW_OPTIONS` → `[rgba reposo, rgba hover, hex header]`.
4. **WhatsApp:** el número se guarda normalizado como `51XXXXXXXXX` en `SiteSetting('whatsapp_number')` y el link como `https://wa.me/51XXXXXXXXX`.
5. **Render público:** `<x-floating-buttons />` recorre los botones ordenados por `orden`, muestra el círculo y, al hacer clic, abre el popover (QR/descripción/enlace).
6. **Tamaño/brillo actuales:** círculo `46x46px`, sombra `8px` (reposo) / `14px` (hover).
```
```

Si quieres regenerar la BD: `php artisan migrate` + `php artisan db:seed --class=FloatingButtonSeeder` + `php artisan storage:link`.
