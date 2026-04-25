<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SiteSetting;

class HomeController extends Controller
{
    /**
     * Mostrar página de inicio
     */
    public function index()
    {
        $bgPath = SiteSetting::get('bg_portal_principal');
        $bgBiblioteca = SiteSetting::get('bg_biblioteca');
        $bgFototeca = SiteSetting::get('bg_fototeca');

        $aportantesRaw = SiteSetting::get('aportantes_data');
        $aportantes = $aportantesRaw ? json_decode($aportantesRaw, true) : [
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

        return view('home', [
            'showAdminPanel' => auth()->check() && (
                auth()->user()->is_admin_global ||
                auth()->user()->modules()->exists()
            ),
            'user'             => auth()->user(),
            'heroBg'           => $bgPath      ? asset('storage/' . $bgPath)      : asset('Fondo.png'),
            'heroBgBiblioteca' => $bgBiblioteca ? asset('storage/' . $bgBiblioteca) : 'https://images.unsplash.com/photo-1507842217343-583bb7270b66?auto=format&fit=crop&w=900&q=80',
            'heroBgFototeca'   => $bgFototeca   ? asset('storage/' . $bgFototeca)   : 'https://images.unsplash.com/photo-1505322022379-7c3353ee6291?auto=format&fit=crop&w=900&q=80',
            'aportantes'       => $aportantes,
        ]);
    }

    public function nosotros()
    {
        return view('nosotros', [
            'showAdminPanel' => auth()->check() && (
                auth()->user()->is_admin_global ||
                auth()->user()->modules()->exists()
            ),
        ]);
    }

    public function contacto()
    {
        return view('contacto', [
            'showAdminPanel' => auth()->check() && (
                auth()->user()->is_admin_global ||
                auth()->user()->modules()->exists()
            ),
        ]);
    }
}
