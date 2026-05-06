<?php

namespace Database\Seeders;

use App\Models\Special;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SpecialSeeder extends Seeder
{
    public function run(): void
    {
        // Colecciones especiales de BIBLIOTECA (module = biblioteca)
        $colecciones = [
            [
                'title'       => 'Terremoto de 1970',
                'description' => 'Colección de libros, artículos y revistas sobre el terremoto del 31 de mayo de 1970 en Áncash: testimonios, análisis histórico, impacto social y proceso de reconstrucción.',
                'type'        => 'libro',
                'order'       => 1,
            ],
            [
                'title'       => 'Patrimonio Arqueológico',
                'description' => 'Publicaciones sobre los sitios arqueológicos de Áncash: Chavín de Huántar, Sechín, Wicahuain y otros centros ceremoniales prehispánicos de la región.',
                'type'        => 'libro',
                'order'       => 2,
            ],
            [
                'title'       => 'Cordillera Blanca y Naturaleza',
                'description' => 'Estudios científicos y divulgativos sobre la Cordillera Blanca, el Parque Nacional Huascarán, los glaciares y la biodiversidad de Áncash.',
                'type'        => 'libro',
                'order'       => 3,
            ],
            [
                'title'       => 'Historia y Cronología Ancashina',
                'description' => 'Obras de historia regional que abarcan desde el período prehispánico hasta el siglo XX, incluyendo cronologías, crónicas y análisis del desarrollo histórico de Áncash.',
                'type'        => 'libro',
                'order'       => 4,
            ],
            [
                'title'       => 'Literatura y Tradición Oral',
                'description' => 'Colección de poesía, narrativa, mitos y leyendas de autores ancashinos, que preservan la identidad cultural y la tradición oral de la región.',
                'type'        => 'libro',
                'order'       => 5,
            ],
            [
                'title'       => 'Lengua Quechua Ancashina',
                'description' => 'Gramáticas, vocabularios, textos pedagógicos y estudios lingüísticos sobre el quechua ancashino, lengua originaria de la sierra de Áncash.',
                'type'        => 'libro',
                'order'       => 6,
            ],
            [
                'title'       => 'Revistas Regionales',
                'description' => 'Publicaciones periódicas de instituciones académicas, culturales y municipales de Áncash: boletines, revistas científicas y culturales de la región.',
                'type'        => 'revista',
                'order'       => 7,
            ],
        ];

        foreach ($colecciones as $data) {
            Special::firstOrCreate(
                ['slug' => Str::slug($data['title'])],
                [
                    'title'       => $data['title'],
                    'description' => $data['description'],
                    'type'        => $data['type'],
                    'module'      => 'biblioteca',
                    'order'       => $data['order'],
                    'is_active'   => true,
                ]
            );
        }
    }
}
