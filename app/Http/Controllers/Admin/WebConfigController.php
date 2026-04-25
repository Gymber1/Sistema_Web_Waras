<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
        $contact = [
            'yape_qr'         => SiteSetting::get('yape_qr'),
            'whatsapp_qr'     => SiteSetting::get('whatsapp_qr'),
            'whatsapp_number' => SiteSetting::get('whatsapp_number'),
        ];
        return view('admin.web-config.config-flotantes', compact('contact'));
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
            'yape_qr'         => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'whatsapp_qr'     => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'whatsapp_number' => ['nullable', 'string', 'digits_between:0,9'],
        ]);

        foreach (self::CONTACT_IMAGES as $field) {
            if ($request->hasFile($field)) {
                $old = SiteSetting::get($field);
                if ($old && Storage::disk('public')->exists($old)) {
                    Storage::disk('public')->delete($old);
                }
                $path = $request->file($field)->store('contact', 'public');
                SiteSetting::set($field, $path);
            }
        }

        $number = preg_replace('/\D/', '', $request->input('whatsapp_number', ''));
        if ($number !== '') {
            if (!str_starts_with($number, '51')) {
                $number = '51' . $number;
            }
        }
        SiteSetting::set('whatsapp_number', $number ?: null);

        return back()->with('success', 'Información de contacto actualizada correctamente.');
    }

    public function destroyContact(string $key)
    {
        abort_unless(in_array($key, self::CONTACT_IMAGES), 404);

        $old = SiteSetting::get($key);
        if ($old && Storage::disk('public')->exists($old)) {
            Storage::disk('public')->delete($old);
        }
        SiteSetting::set($key, null);

        return back()->with('success', 'QR eliminado correctamente.');
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
