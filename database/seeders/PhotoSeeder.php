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
        $photosData = [
            [
                'title'       => 'Plaza de Armas de Huaraz, 1965',
                'description' => 'Vista de la Plaza de Armas de Huaraz antes del terremoto del 31 de mayo de 1970. Se aprecia la catedral y los edificios coloniales de la época.',
                'year'        => 1965,
                'location'    => 'Huaraz, Ancash',
                'format'      => 'JPG',
                'tag'         => 'Antes del Terremoto',
                'photographer'=> 'Archivo Fotográfico Regional',
                'category'    => 'Plaza de Armas y Catedral',
            ],
            [
                'title'       => 'Barrio La Soledad, 1968',
                'description' => 'Calles del barrio La Soledad en Huaraz, uno de los más antiguos de la ciudad, fotografiado dos años antes del terremoto.',
                'year'        => 1968,
                'location'    => 'La Soledad, Huaraz',
                'format'      => 'JPG',
                'tag'         => 'Antes del Terremoto',
                'photographer'=> 'Archivo Fotográfico Regional',
                'category'    => 'La Soledad',
            ],
            [
                'title'       => 'Terremoto de Huaraz, 31 de mayo de 1970',
                'description' => 'Fotografía que documenta la destrucción causada por el terremoto del 31 de mayo de 1970 en el centro de Huaraz.',
                'year'        => 1970,
                'location'    => 'Huaraz, Ancash',
                'format'      => 'JPG',
                'tag'         => 'Terremoto',
                'photographer'=> 'Archivo Fotográfico Regional',
                'category'    => 'Terremoto del 31 de mayo de 1970',
            ],
            [
                'title'       => 'Reconstrucción de Huaraz, 1972',
                'description' => 'Trabajos de reconstrucción de la ciudad de Huaraz dos años después del terremoto. Se observan las nuevas edificaciones del centro urbano.',
                'year'        => 1972,
                'location'    => 'Huaraz, Ancash',
                'format'      => 'JPG',
                'tag'         => 'Después del Terremoto',
                'photographer'=> 'Carlos Zegarra Huamán',
                'category'    => 'Casas y Edificios',
            ],
            [
                'title'       => 'Nevado Huascarán desde Yungay',
                'description' => 'Vista majestuosa del Nevado Huascarán, el pico más alto del Perú, fotografiado desde las pampas de Yungay al amanecer.',
                'year'        => 1985,
                'location'    => 'Yungay, Ancash',
                'format'      => 'JPG',
                'tag'         => 'Siglo XXI',
                'photographer'=> 'Martín Chambi Lanza',
                'category'    => 'Huascarán',
            ],
            [
                'title'       => 'Laguna Parón con el Artesonraju',
                'description' => 'La Laguna Parón reflejando el Artesonraju, nevado que sirvió de inspiración para el logo de los Juegos Olímpicos de Invierno.',
                'year'        => 2005,
                'location'    => 'Laguna Parón, Caraz',
                'format'      => 'JPG',
                'tag'         => 'Siglo XXI',
                'photographer'=> 'Edmundo Puma Gonzáles',
                'category'    => 'Artesonraju',
            ],
            [
                'title'       => 'Fiesta del Señor de Mayo, Huaraz',
                'description' => 'Procesión de la festividad del Señor de Mayo en Huaraz, una de las celebraciones religiosas más importantes del Callejón de Huaylas.',
                'year'        => 1990,
                'location'    => 'Huaraz, Ancash',
                'format'      => 'JPG',
                'tag'         => 'Antes del Terremoto',
                'photographer'=> 'Rosendo Flores Quispe',
                'category'    => 'Fiesta del Señor de Mayo',
            ],
            [
                'title'       => 'Ruinas de Chavín de Huántar',
                'description' => 'Vista de las estructuras de piedra del complejo arqueológico de Chavín de Huántar, declarado Patrimonio Mundial de la UNESCO.',
                'year'        => 1992,
                'location'    => 'Chavín de Huántar, Ancash',
                'format'      => 'JPG',
                'tag'         => 'Siglo XXI',
                'photographer'=> 'Prof. Carlos Mendoza Silva',
                'category'    => 'Chavín',
            ],
            [
                'title'       => 'Aluvión de Huaraz de 1941',
                'description' => 'Documentación fotográfica del aluvión que devastó gran parte de Huaraz en 1941, producido por el desborde de la Laguna Palcacocha.',
                'year'        => 1941,
                'location'    => 'Huaraz, Ancash',
                'format'      => 'JPG',
                'tag'         => 'Antes del Terremoto',
                'photographer'=> 'Archivo Fotográfico Regional',
                'category'    => 'Aluvión de Huaraz de 1941',
            ],
            [
                'title'       => 'Panorámica de Huaraz, 2010',
                'description' => 'Vista panorámica de la ciudad de Huaraz con la Cordillera Blanca al fondo, tomada desde el cerro Rataquenua.',
                'year'        => 2010,
                'location'    => 'Huaraz, Ancash',
                'format'      => 'JPG',
                'tag'         => 'Siglo XXI',
                'photographer'=> 'Edmundo Puma Gonzáles',
                'category'    => 'Panorámica',
            ],
            [
                'title'       => 'Semana Santa en Huaraz',
                'description' => 'Procesión de Semana Santa en las calles del centro histórico de Huaraz, tradición que se mantiene con gran fervor popular.',
                'year'        => 2003,
                'location'    => 'Huaraz, Ancash',
                'format'      => 'JPG',
                'tag'         => 'Siglo XXI',
                'photographer'=> 'Rosendo Flores Quispe',
                'category'    => 'Semana Santa Huaracina',
            ],
            [
                'title'       => 'Barrio Centenario de Huaraz',
                'description' => 'Vista del barrio Centenario en la ciudad de Huaraz, uno de los sectores con mayor crecimiento urbano en la posguerra de 1970.',
                'year'        => 1978,
                'location'    => 'Centenario, Huaraz',
                'format'      => 'JPG',
                'tag'         => 'Después del Terremoto',
                'photographer'=> 'Carlos Zegarra Huamán',
                'category'    => 'Centenario',
            ],
        ];

        foreach ($photosData as $data) {
            $photo = Photo::create([
                'title'          => $data['title'],
                'slug'           => Str::slug($data['title']),
                'description'    => $data['description'],
                'year'           => $data['year'],
                'location'       => $data['location'],
                'format'         => $data['format'],
                'provider'       => 'Fototeca WARAS',
                'thumbnail_path' => null,
                'full_image_path'=> null,
                'source_type'    => 'none',
                'external_url'   => null,
                'is_special'     => false,
                'tag_id'         => PhotoTag::where('name', $data['tag'])->first()?->id,
            ]);

            // Asociar fotógrafo
            $photographer = Photographer::firstOrCreate(
                ['full_name' => $data['photographer']],
                ['slug' => Str::slug($data['photographer'])]
            );
            $photo->photographers()->attach($photographer->id, ['order' => 1]);

            // Asociar categoría de fototeca
            $category = Category::where('name', $data['category'])->where('type', 'fototeca')->first();
            if ($category) {
                $photo->categories()->attach($category->id);
            }
        }
    }
}
