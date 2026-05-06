<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Photo;
use App\Models\PhotoTag;
use App\Models\Photographer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PhotoSeeder extends Seeder
{
    public function run(): void
    {
        // Helper: busca la categoría más específica disponible en orden de preferencia
        $cat = fn(array $names) => collect($names)
            ->map(fn($n) => Category::where('name', $n)->where('type', 'fototeca')->first())
            ->filter()
            ->first();

        $photosData = [
            // ── Por Ciudades / Plaza de Armas y Catedral ──
            [
                'title'       => 'Plaza de Armas de Huaraz, 1965',
                'description' => 'Vista de la Plaza de Armas de Huaraz antes del terremoto del 31 de mayo de 1970. Se aprecia la catedral y los edificios coloniales de la época.',
                'year'        => 1965,
                'year_type'   => 'exact',
                'location'    => 'Huaraz, Áncash',
                'tag'         => 'Antes del Terremoto',
                'photographer'=> 'Archivo Fotográfico Regional',
                'categories'  => ['Antes del Terremoto', 'Plaza de Armas y Catedral'],
            ],
            [
                'title'       => 'Catedral de Huaraz después del terremoto',
                'description' => 'Estado de la Catedral de Huaraz tras el sismo del 31 de mayo de 1970. La estructura quedó gravemente dañada junto con el resto del centro histórico.',
                'year'        => 1970,
                'year_type'   => 'exact',
                'location'    => 'Huaraz, Áncash',
                'tag'         => 'Terremoto',
                'photographer'=> 'Carlos Zegarra Huamán',
                'categories'  => ['Terremoto', 'Plaza de Armas y Catedral'],
            ],
            // ── Por Barrios ──
            [
                'title'       => 'Barrio La Soledad, 1968',
                'description' => 'Calles del barrio La Soledad en Huaraz, uno de los más antiguos de la ciudad, fotografiado dos años antes del terremoto.',
                'year'        => 1968,
                'year_type'   => 'exact',
                'location'    => 'La Soledad, Huaraz',
                'tag'         => 'Antes del Terremoto',
                'photographer'=> 'Archivo Fotográfico Regional',
                'categories'  => ['Antes del Terremoto', 'La Soledad'],
            ],
            [
                'title'       => 'Barrio Centenario de Huaraz, 1978',
                'description' => 'Vista del barrio Centenario en la ciudad de Huaraz, uno de los sectores con mayor crecimiento urbano en la posguerra de 1970.',
                'year'        => 1978,
                'year_type'   => 'exact',
                'location'    => 'Centenario, Huaraz',
                'tag'         => 'Después del Terremoto',
                'photographer'=> 'Carlos Zegarra Huamán',
                'categories'  => ['Después del Terremoto', 'Centenario'],
            ],
            [
                'title'       => 'Barrio Huarupampa en la década de 1960',
                'description' => 'Imagen histórica del barrio Huarupampa, sector residencial tradicional de Huaraz, antes del terremoto de 1970.',
                'year'        => 1963,
                'year_type'   => 'exact',
                'location'    => 'Huarupampa, Huaraz',
                'tag'         => 'Antes del Terremoto',
                'photographer'=> 'Archivo Fotográfico Regional',
                'categories'  => ['Antes del Terremoto', 'Huarupampa'],
            ],
            // ── Panorámica ──
            [
                'title'       => 'Panorámica de Huaraz, 2010',
                'description' => 'Vista panorámica de la ciudad de Huaraz con la Cordillera Blanca al fondo, tomada desde el cerro Rataquenua.',
                'year'        => 2010,
                'year_type'   => 'exact',
                'location'    => 'Huaraz, Áncash',
                'tag'         => 'Siglo XXI',
                'photographer'=> 'Edmundo Puma Gonzáles',
                'categories'  => ['Siglo XXI', 'Panorámica'],
            ],
            [
                'title'       => 'Huaraz antes del terremoto, vista aérea',
                'description' => 'Fotografía aérea de la ciudad de Huaraz tomada en la década de 1960, mostrando la trama urbana colonial que sería destruida en 1970.',
                'year_from'   => 1960,
                'year_to'     => 1969,
                'year_type'   => 'range',
                'location'    => 'Huaraz, Áncash',
                'tag'         => 'Antes del Terremoto',
                'photographer'=> 'Archivo Fotográfico Regional',
                'categories'  => ['Antes del Terremoto', 'Panorámica'],
            ],
            // ── Casas y Edificios ──
            [
                'title'       => 'Reconstrucción de Huaraz, 1972',
                'description' => 'Trabajos de reconstrucción de la ciudad de Huaraz dos años después del terremoto. Se observan las nuevas edificaciones del centro urbano.',
                'year'        => 1972,
                'year_type'   => 'exact',
                'location'    => 'Huaraz, Áncash',
                'tag'         => 'Después del Terremoto',
                'photographer'=> 'Carlos Zegarra Huamán',
                'categories'  => ['Después del Terremoto', 'Casas y Edificios'],
            ],
            // ── Desastres ──
            [
                'title'       => 'Aluvión de Huaraz de 1941',
                'description' => 'Documentación fotográfica del aluvión que devastó gran parte de Huaraz en 1941, producido por el desborde de la Laguna Palcacocha.',
                'year'        => 1941,
                'year_type'   => 'exact',
                'location'    => 'Huaraz, Áncash',
                'tag'         => 'Antes del Terremoto',
                'photographer'=> 'Archivo Fotográfico Regional',
                'categories'  => ['Aluvión de Huaraz de 1941'],
            ],
            [
                'title'       => 'Terremoto de Huaraz, 31 de mayo de 1970',
                'description' => 'Fotografía que documenta la destrucción causada por el terremoto del 31 de mayo de 1970 en el centro de Huaraz.',
                'year'        => 1970,
                'year_type'   => 'exact',
                'location'    => 'Huaraz, Áncash',
                'tag'         => 'Terremoto',
                'photographer'=> 'Archivo Fotográfico Regional',
                'categories'  => ['Terremoto del 31 de mayo de 1970'],
            ],
            [
                'title'       => 'Camposanto de Yungay tras el aluvión de 1970',
                'description' => 'El aluvión del 31 de mayo de 1970 sepultó la ciudad de Yungay bajo toneladas de barro y roca. Solo emergieron las palmeras de la Plaza de Armas.',
                'year'        => 1970,
                'year_type'   => 'exact',
                'location'    => 'Yungay, Áncash',
                'tag'         => 'Terremoto',
                'photographer'=> 'María Luisa Tarazona Espinoza',
                'categories'  => ['Aluvión del 31 de mayo de 1970'],
            ],
            // ── Tradiciones ──
            [
                'title'       => 'Fiesta del Señor de Mayo, Huaraz',
                'description' => 'Procesión de la festividad del Señor de Mayo en Huaraz, una de las celebraciones religiosas más importantes del Callejón de Huaylas.',
                'year'        => 1990,
                'year_type'   => 'exact',
                'location'    => 'Huaraz, Áncash',
                'tag'         => 'Antes del Terremoto',
                'photographer'=> 'Rosendo Flores Quispe',
                'categories'  => ['Fiesta del Señor de Mayo'],
            ],
            [
                'title'       => 'Semana Santa en Huaraz',
                'description' => 'Procesión de Semana Santa en las calles del centro histórico de Huaraz, tradición que se mantiene con gran fervor popular.',
                'year'        => 2003,
                'year_type'   => 'exact',
                'location'    => 'Huaraz, Áncash',
                'tag'         => 'Siglo XXI',
                'photographer'=> 'Rosendo Flores Quispe',
                'categories'  => ['Semana Santa Huaracina'],
            ],
            // ── Patrimonio Arqueológico ──
            [
                'title'       => 'Ruinas de Chavín de Huántar',
                'description' => 'Vista de las estructuras de piedra del complejo arqueológico de Chavín de Huántar, declarado Patrimonio Mundial de la UNESCO.',
                'year'        => 1992,
                'year_type'   => 'exact',
                'location'    => 'Chavín de Huántar, Áncash',
                'tag'         => 'Siglo XXI',
                'photographer'=> 'Prof. Carlos Mendoza Silva',
                'categories'  => ['Chavín'],
            ],
            [
                'title'       => 'Complejo Arqueológico de Sechín',
                'description' => 'Los relieves de piedra del Complejo de Sechín muestran escenas de guerra y rituales que datan de aproximadamente 1600 a.C.',
                'year'        => 1988,
                'year_type'   => 'exact',
                'location'    => 'Casma, Áncash',
                'tag'         => 'Siglo XXI',
                'photographer'=> 'Prof. Carlos Mendoza Silva',
                'categories'  => ['Sechín'],
            ],
            // ── Parque Nacional Huascarán ──
            [
                'title'       => 'Nevado Huascarán desde Yungay',
                'description' => 'Vista majestuosa del Nevado Huascarán, el pico más alto del Perú a 6,768 msnm, fotografiado desde las pampas de Yungay al amanecer.',
                'year'        => 1985,
                'year_type'   => 'exact',
                'location'    => 'Yungay, Áncash',
                'tag'         => 'Siglo XXI',
                'photographer'=> 'Martín Chambi Lanza',
                'categories'  => ['Huascarán'],
            ],
            [
                'title'       => 'Laguna Parón con el Artesonraju',
                'description' => 'La Laguna Parón reflejando el Artesonraju, nevado que sirvió de inspiración para el logo de los Juegos Olímpicos de Invierno de 1968.',
                'year'        => 2005,
                'year_type'   => 'exact',
                'location'    => 'Laguna Parón, Caraz',
                'tag'         => 'Siglo XXI',
                'photographer'=> 'Edmundo Puma Gonzáles',
                'categories'  => ['Artesonraju', 'Laguna Parón'],
            ],
            [
                'title'       => 'Alpamayo — La Montaña más Bella del Mundo',
                'description' => 'El Alpamayo (5,947 msnm) fue elegido en 1966 por la revista alpinista alemana Alpinismus como la montaña más bella del mundo por su pirámide perfecta.',
                'year'        => 2008,
                'year_type'   => 'exact',
                'location'    => 'Santa Cruz, Áncash',
                'tag'         => 'Siglo XXI',
                'photographer'=> 'Martín Chambi Lanza',
                'categories'  => ['Alpamayo'],
            ],
        ];

        foreach ($photosData as $data) {
            $photo = Photo::create([
                'title'           => $data['title'],
                'slug'            => Str::slug($data['title']),
                'description'     => $data['description'] ?? null,
                'year_type'       => $data['year_type'] ?? 'exact',
                'year'            => $data['year_type'] === 'exact' ? ($data['year'] ?? null) : null,
                'year_from'       => $data['year_type'] === 'range' ? ($data['year_from'] ?? null) : null,
                'year_to'         => $data['year_type'] === 'range' ? ($data['year_to'] ?? null) : null,
                'location'        => $data['location'] ?? null,
                'provider'        => 'Fototeca WARAS',
                'thumbnail_path'  => null,
                'full_image_path' => null,
                'source_type'     => 'none',
                'external_url'    => null,
                'is_special'      => false,
                'tag_id'          => PhotoTag::where('name', $data['tag'])->first()?->id,
            ]);

            // Fotógrafo
            $photographer = Photographer::firstOrCreate(
                ['full_name' => $data['photographer']],
                ['slug' => Str::slug($data['photographer'])]
            );
            $photo->photographers()->attach($photographer->id, ['order' => 1]);

            // Categorías — asigna todas las que encuentre
            foreach ($data['categories'] as $catName) {
                $category = Category::where('name', $catName)->where('type', 'fototeca')->first();
                if ($category) {
                    $photo->categories()->syncWithoutDetaching([$category->id]);
                }
            }
        }
    }
}
