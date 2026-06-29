<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FloatingButton;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WebConfigController extends Controller
{
    private const SITES = [
        'bg_portal_principal' => ['label' => 'Portal Principal', 'icon' => '🌐', 'route_hint' => '/'],
        'bg_biblioteca'       => ['label' => 'Biblioteca',       'icon' => '📚', 'route_hint' => '/biblioteca'],
        'bg_fototeca'         => ['label' => 'Fototeca',         'icon' => '📷', 'route_hint' => '/fototeca'],
    ];

    // Image-based contact keys
    private const CONTACT_IMAGES = ['yape_qr', 'whatsapp_qr'];

    public function index()
    {
        return view('admin.web-config.index');
    }

    public function fondos()
    {
        $settings = [];
        foreach (self::SITES as $key => $meta) {
            $settings[$key] = array_merge($meta, ['value' => SiteSetting::get($key)]);
        }
        return view('admin.web-config.config-fondos', compact('settings'));
    }

    public function contacto()
    {
        $buttons = FloatingButton::orderBy('orden')->get();
        return view('admin.web-config.config-flotantes', compact('buttons'));
    }

    public function update(Request $request, string $key)
    {
        abort_unless(array_key_exists($key, self::SITES), 404);

        $request->validate([
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        $old = SiteSetting::get($key);
        if ($old && Storage::disk('public')->exists($old)) {
            Storage::disk('public')->delete($old);
        }

        $path = $request->file('image')->store('backgrounds', 'public');
        SiteSetting::set($key, $path);

        return back()->with('success', 'Fondo de ' . self::SITES[$key]['label'] . ' actualizado correctamente.');
    }

    public function destroy(string $key)
    {
        abort_unless(array_key_exists($key, self::SITES), 404);

        $old = SiteSetting::get($key);
        if ($old && Storage::disk('public')->exists($old)) {
            Storage::disk('public')->delete($old);
        }

        SiteSetting::set($key, null);

        return back()->with('success', 'Fondo de ' . self::SITES[$key]['label'] . ' eliminado. Se usará el fondo por defecto.');
    }

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

    public function destroyContact(string $key)
    {
        // Legacy: eliminar QR de Yape/WA desde la tabla (solo la imagen)
        $btn = FloatingButton::where('slug', $key === 'yape_qr' ? 'yape' : 'whatsapp')->first();
        if ($btn && $btn->imagen && Storage::disk('public')->exists($btn->imagen)) {
            Storage::disk('public')->delete($btn->imagen);
            $btn->imagen = null;
            $btn->save();
        }
        SiteSetting::set($key, null);
        return back()->with('success', 'QR eliminado correctamente.');
    }

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

    public function destroyFloatingButtonLogo(FloatingButton $floatingButton)
    {
        if ($floatingButton->logo && Storage::disk('public')->exists($floatingButton->logo)) {
            Storage::disk('public')->delete($floatingButton->logo);
        }
        $floatingButton->logo = null;
        $floatingButton->save();
        return back()->with('success', 'Logo eliminado. Se usará el logo por defecto.');
    }

    // ── Editar Contacto ──────────────────────────────────────────────────────

    private const CONTACT_ICON_KEYS = ['contact_icon_direccion', 'contact_icon_telefono', 'contact_icon_email'];

    public function editContacto()
    {
        $data = [
            'contact_direccion'      => SiteSetting::get('contact_direccion', "Esq. Av. Luzuriaga con Av. 28 de Julio\nHuaraz, Áncash, Perú"),
            'contact_telefono'       => SiteSetting::get('contact_telefono', '952 845 942'),
            'contact_email'          => SiteSetting::get('contact_email', 'giber.garcia@pcca.org'),
            'contact_icon_direccion' => SiteSetting::get('contact_icon_direccion'),
            'contact_icon_telefono'  => SiteSetting::get('contact_icon_telefono'),
            'contact_icon_email'     => SiteSetting::get('contact_icon_email'),
        ];
        return view('admin.web-config.config-contacto', compact('data'));
    }

    public function updateEditContacto(Request $request)
    {
        $request->validate([
            'contact_direccion'      => ['required', 'string', 'max:300'],
            'contact_telefono'       => ['required', 'string', 'max:100'],
            'contact_email'          => ['required', 'string', 'max:150'],
            'contact_icon_direccion' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:1024'],
            'contact_icon_telefono'  => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:1024'],
            'contact_icon_email'     => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:1024'],
        ]);

        foreach (['contact_direccion', 'contact_telefono', 'contact_email'] as $key) {
            SiteSetting::set($key, $request->input($key));
        }

        foreach (self::CONTACT_ICON_KEYS as $field) {
            if ($request->hasFile($field)) {
                $old = SiteSetting::get($field);
                if ($old && Storage::disk('public')->exists($old)) {
                    Storage::disk('public')->delete($old);
                }
                $path = $request->file($field)->store('contact-icons', 'public');
                SiteSetting::set($field, $path);
            }
        }

        return back()->with('success', 'Información de contacto actualizada correctamente.');
    }

    public function destroyContactIcon(string $key)
    {
        abort_unless(in_array($key, self::CONTACT_ICON_KEYS), 404);

        $old = SiteSetting::get($key);
        if ($old && Storage::disk('public')->exists($old)) {
            Storage::disk('public')->delete($old);
        }
        SiteSetting::set($key, null);

        return back()->with('success', 'Ícono eliminado. Se mostrará el ícono por defecto.');
    }

    public function aportantes()
    {
        $raw = SiteSetting::get('aportantes_data');
        $aportantes = $raw ? json_decode($raw, true) : $this->defaultAportantes();
        return view('admin.web-config.config-aportantes', compact('aportantes'));
    }

    public function aportantesUpdate(Request $request)
    {
        $data = [
            'director' => [
                'nombre' => $request->input('director_nombre', ''),
                'cargo'  => $request->input('director_cargo', ''),
                'bio'    => $request->input('director_bio', ''),
                'foto'   => $request->input('director_foto_actual', ''),
            ],
            'categorias' => [],
        ];

        if ($request->hasFile('director_foto')) {
            $path = $request->file('director_foto')->store('aportantes', 'public');
            $data['director']['foto'] = '/storage/' . $path;
        }

        foreach ($request->input('categorias', []) as $ci => $cat) {
            // Icono: puede ser slug predeterminado o imagen subida
            $icono = $cat['icono'] ?? 'building';
            $iconoFileKey = "categorias.{$ci}.icono_file";
            if ($request->hasFile($iconoFileKey)) {
                $path = $request->file($iconoFileKey)->store('aportantes', 'public');
                $icono = '/storage/' . $path;
            } elseif ($icono === '__file__') {
                $icono = 'building'; // fallback si marcó __file__ pero no subió nada
            }

            $items = [];
            foreach ($cat['items'] ?? [] as $ii => $item) {
                $foto = $item['foto'] ?? '';
                $fotoFileKey = "categorias.{$ci}.items.{$ii}.foto_file";
                if ($request->hasFile($fotoFileKey)) {
                    $path = $request->file($fotoFileKey)->store('aportantes', 'public');
                    $foto = '/storage/' . $path;
                }
                $items[] = [
                    'nombre'      => $item['nombre']      ?? '',
                    'descripcion' => $item['descripcion'] ?? '',
                    'foto'        => $foto,
                ];
            }
            $data['categorias'][] = [
                'titulo' => $cat['titulo'] ?? '',
                'icono'  => $icono,
                'items'  => $items,
            ];
        }

        SiteSetting::set('aportantes_data', json_encode($data, JSON_UNESCAPED_UNICODE));

        return back()->with('success', 'Aportantes actualizados correctamente.');
    }

    // ── NUESTRA ORGANIZACIÓN ─────────────────────────────────────────────────

    public function organizacion()
    {
        $org = SiteSetting::organizacion();
        return view('admin.web-config.config-organizacion', compact('org'));
    }

    public function organizacionUpdate(Request $request)
    {
        $org = SiteSetting::organizacion();

        // Campos de texto simples
        $textKeys = [
            'hero_title', 'hero_subtitle',
            'quienes_eyebrow', 'quienes_title', 'quienes_title_em',
            'quienes_p1', 'quienes_p2', 'quienes_p3', 'quienes_img_label',
            'finalidad_title', 'finalidad_text',
            'objetivo_title',
            'lineas_title', 'lineas_subtitle',
            'objetivos_label', 'beneficiarios_label',
            'premio_title', 'premio_eyebrow', 'premio_text', 'premio_video',
            'premio_rec_label', 'premio_ministerio',
            'director_label', 'director_name', 'director_bio',
        ];
        foreach ($textKeys as $key) {
            if ($request->has($key)) {
                $org[$key] = trim((string) $request->input($key, ''));
            }
        }

        // Listas (se reciben como arrays; se filtran vacíos)
        $listKeys = ['objetivo_items', 'objetivos_items', 'beneficiarios_items'];
        foreach ($listKeys as $key) {
            if ($request->has($key)) {
                $org[$key] = array_values(array_filter(
                    array_map(fn($v) => trim((string) $v), $request->input($key, [])),
                    fn($v) => $v !== ''
                ));
            }
        }

        // Imágenes (subida opcional; conservar la actual si no se sube nada)
        $imageFields = [
            'quienes_img'   => 'organizacion',
            'finalidad_img' => 'organizacion',
            'objetivo_img'  => 'organizacion',
            'director_img'  => 'organizacion',
        ];
        foreach ($imageFields as $field => $folder) {
            if ($request->hasFile($field)) {
                $request->validate([
                    $field => ['image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
                ]);
                // Borrar la anterior si era una imagen subida (en storage)
                $current = $org[$field] ?? '';
                if (is_string($current) && str_starts_with($current, '/storage/')) {
                    $rel = substr($current, strlen('/storage/'));
                    if (Storage::disk('public')->exists($rel)) {
                        Storage::disk('public')->delete($rel);
                    }
                }
                $path = $request->file($field)->store($folder, 'public');
                $org[$field] = '/storage/' . $path;
            }
        }

        SiteSetting::set('organizacion_data', json_encode($org, JSON_UNESCAPED_UNICODE));

        return back()->with('success', 'Sección "Nuestra Organización" actualizada correctamente.');
    }

    public function icono()
    {
        $icons = [
            'nav_logo_portal'     => SiteSetting::get('nav_logo_portal'),
            'nav_logo_biblioteca' => SiteSetting::get('nav_logo_biblioteca'),
            'nav_logo_fototeca'   => SiteSetting::get('nav_logo_fototeca'),
        ];
        return view('admin.web-config.config-icono', compact('icons'));
    }

    private const LOGO_KEYS = ['nav_logo_portal', 'nav_logo_biblioteca', 'nav_logo_fototeca'];

    public function iconoUpdate(Request $request)
    {
        $key = $request->input('key');
        abort_unless(in_array($key, self::LOGO_KEYS), 422);

        $request->validate([
            'icono' => ['required', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:1024'],
        ], [
            'icono.required' => 'Debes seleccionar una imagen antes de guardar.',
            'icono.image'    => 'El archivo debe ser una imagen.',
            'icono.mimes'    => 'Solo se permiten archivos JPG, PNG, WEBP o SVG.',
            'icono.max'      => 'La imagen no debe superar 1 MB.',
        ]);

        $old = SiteSetting::get($key);
        if ($old && Storage::disk('public')->exists($old)) {
            Storage::disk('public')->delete($old);
        }

        $path = $request->file('icono')->store('logos', 'public');
        SiteSetting::set($key, $path);

        return back()->with('success', 'Icono actualizado correctamente.');
    }

    public function iconoDestroy(Request $request)
    {
        $key = $request->input('key');
        abort_unless(in_array($key, self::LOGO_KEYS), 422);

        $old = SiteSetting::get($key);
        if ($old && Storage::disk('public')->exists($old)) {
            Storage::disk('public')->delete($old);
        }
        SiteSetting::set($key, null);

        return back()->with('success', 'Icono eliminado.');
    }

    // ── TEXTOS HERO ──────────────────────────────────────────────────────────

    public function heroTextos()
    {
        $defaults = [
            'hero_portal_eyebrow'   => 'Asociación de Ciencia y Cultura',
            'hero_portal_title'     => 'Portal de la Ciencia y la Cultura Ancashina',
            'hero_portal_subtitle'  => '"Descubre nuestras colecciones de libros, fotos, música, artes y eventos históricos que preservan la memoria de nuestra región."',
            'hero_portal_cta'       => 'Explorar Servicios',
            'hero_biblioteca_title'    => 'Biblioteca Digital Ancashina',
            'hero_biblioteca_subtitle' => '"Conocimiento e historia accesible para todos"',
            'hero_fototeca_eyebrow'    => 'Archivo Visual de Áncash',
            'hero_fototeca_title'      => 'Fototeca Digital Ancashina',
            'hero_fototeca_subtitle'   => 'Preservando y compartiendo la memoria visual, histórica y cultural de nuestra región.',
        ];

        $values = [];
        foreach ($defaults as $key => $default) {
            $values[$key] = SiteSetting::get($key) ?? $default;
        }

        return view('admin.web-config.hero-textos', compact('values', 'defaults'));
    }

    public function updateHeroTextos(Request $request)
    {
        $allowed = [
            'hero_portal_eyebrow', 'hero_portal_title', 'hero_portal_subtitle', 'hero_portal_cta',
            'hero_biblioteca_title', 'hero_biblioteca_subtitle',
            'hero_fototeca_eyebrow', 'hero_fototeca_title', 'hero_fototeca_subtitle',
        ];

        $sectionLabels = [
            'portal'     => 'Portal Principal',
            'biblioteca' => 'Biblioteca Digital',
            'fototeca'   => 'Fototeca Digital',
        ];

        $section = $request->input('section');

        foreach ($allowed as $key) {
            if ($request->has($key)) {
                SiteSetting::set($key, trim($request->input($key, '')));
            }
        }

        $label = $sectionLabels[$section] ?? 'Textos del hero';
        return back()->with('success', $label . ' actualizado correctamente.');
    }

    private function defaultAportantes(): array
    {
        return [
            'director' => [
                'nombre' => 'Giber Garcia Alamo',
                'cargo'  => 'Bibliotecólogo',
                'bio'    => 'Promotor inicial de la recopilación histórica. Asumió la dirección para rescatar, catalogar y promover la Identidad Ancashina a través de esta plataforma digital.',
                'foto'   => '/giber.png',
            ],
            'categorias' => [
                [
                    'titulo' => 'Empresas Auspiciadoras',
                    'icono'  => 'building',
                    'items'  => [
                        ['nombre' => 'Minera Antamina S.A.',    'descripcion' => 'Auspiciador Platino. Su apoyo financiero ha sido fundamental para mantener nuestra infraestructura tecnológica y adquirir los servidores principales de la plataforma.', 'foto' => ''],
                        ['nombre' => 'Constructora Andes EIRL', 'descripcion' => 'Aportes directos para la viabilidad, contratación del equipo de digitalización inicial y adquisición de escáneres planetarios.', 'foto' => ''],
                    ],
                ],
                [
                    'titulo' => 'Donantes de Colecciones y Libros',
                    'icono'  => 'heart',
                    'items'  => [
                        ['nombre' => 'Familia Alba',       'descripcion' => 'Cedieron temporalmente su invaluable colección privada de Historia Ancashina, permitiendo la digitalización de más de 120 volúmenes únicos.', 'foto' => ''],
                        ['nombre' => 'Dr. Carlos Ramirez', 'descripcion' => 'Aportó de forma desinteresada su hemeroteca completa de revistas literarias y recortes periodísticos publicados entre 1950 y 1980.', 'foto' => ''],
                    ],
                ],
                [
                    'titulo' => 'Instituciones Aliadas',
                    'icono'  => 'landmark',
                    'items'  => [
                        ['nombre' => 'Universidad Nacional Santiago Antúnez de Mayolo (UNASAM)', 'descripcion' => 'Brinda soporte académico, valida la veracidad de los documentos históricos y facilita la participación de estudiantes voluntarios.', 'foto' => ''],
                        ['nombre' => 'Biblioteca Pública Municipal de Huaraz',                  'descripcion' => 'Aliado estratégico en el rescate de la identidad. Fueron los primeros en acoger la idea de fortalecer el patrimonio digital ancashino.', 'foto' => ''],
                    ],
                ],
            ],
        ];
    }
}
