<?php

namespace Database\Seeders;

use App\Models\Photo;
use App\Models\Photographer;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PhotoSeeder extends Seeder
{
    /**
     * Crear fotos/archivos visuales con relaciones a fotógrafos y categorías.
     * Demuestra la escalabilidad y reutilización de categorías entre módulos.
     */
    public function run(): void
    {
        $faker = Faker::create('es_ES');

        $photos_data = [
            [
                'title' => 'Nevado Huascarán Amanecer',
                'description' => 'Vista majestuosa del Nevado Huascarán durante el amanecer desde Yungay',
                'capture_date' => '1980-06-15',
                'resolution' => '1920x1080',
                'location' => 'Yungay, Ancash',
                'format' => 'JPG',
                'photographer' => 'Martín Chambi Lanza',
                'categories' => ['Naturaleza'],
            ],
            [
                'title' => 'Plaza de Armas de Huaraz 1965',
                'description' => 'Fotografía histórica de la Plaza de Armas antes del terremoto de 1970',
                'capture_date' => '1965-05-20',
                'resolution' => '800x600',
                'location' => 'Huaraz, Ancash',
                'format' => 'JPG',
                'photographer' => 'Archivo Fotográfico Regional',
                'categories' => ['Urbana'],
            ],
            [
                'title' => 'Templo de Chavín de Huántar',
                'description' => 'Estructura arqueológica del importante templo pre-inca en Chavín',
                'capture_date' => '1992-03-10',
                'resolution' => '1600x1200',
                'location' => 'Chavín de Huántar, Ancash',
                'format' => 'JPG',
                'photographer' => 'Prof. Carlos Mendoza Silva',
                'categories' => ['Arquitectura'],
            ],
            [
                'title' => 'Campesinos en Mercado Dominical',
                'description' => 'Escena costumbrista del mercado dominical de Huaraz con indígenas',
                'capture_date' => '1978-07-02',
                'resolution' => '1024x768',
                'location' => 'Huaraz, Ancash',
                'format' => 'JPG',
                'photographer' => 'Fotógrafo Anónimo',
                'categories' => ['Urbana'],
            ],
            [
                'title' => 'Callejón de Huaylas Panorámica',
                'description' => 'Vista panorámica del hermoso Callejón de Huaylas desde Carhuaz',
                'capture_date' => '1985-09-15',
                'resolution' => '2048x1080',
                'location' => 'Carhuaz, Ancash',
                'format' => 'JPG',
                'photographer' => 'Carlos Zegarra Huamán',
                'categories' => ['Naturaleza'],
            ],
            [
                'title' => 'Laguna Parón Reflexión',
                'description' => 'Fotografía de la hermosa Laguna Parón reflejando los nevados',
                'capture_date' => '2005-08-20',
                'resolution' => '1920x1440',
                'location' => 'Laguna Parón, Ancash',
                'format' => 'PNG',
                'photographer' => 'Edmundo Puma Gonzáles',
                'categories' => ['Naturaleza'],
            ],
            [
                'title' => 'Puente Colonial Yungay',
                'description' => 'Estructura del puente colonial que atraviesa el río en Yungay',
                'capture_date' => '1968-04-05',
                'resolution' => '1024x576',
                'location' => 'Yungay, Ancash',
                'format' => 'JPG',
                'photographer' => 'Acervo Histórico Yungaíno',
                'categories' => ['Arquitectura'],
            ],
            [
                'title' => 'Festival Andino Ancashino',
                'description' => 'Registro de festividades tradicionales con comunidades locales',
                'capture_date' => '2010-06-28',
                'resolution' => '1920x1080',
                'location' => 'Huaraz, Ancash',
                'format' => 'JPG',
                'photographer' => 'Rosendo Flores Quispe',
                'categories' => ['Urbana'],
            ],
        ];

        foreach ($photos_data as $data) {
            $photo = Photo::create([
                'title' => $data['title'],
                'slug' => str_replace(' ', '-', strtolower($data['title'])),
                'description' => $data['description'],
                'capture_date' => $data['capture_date'],
                'resolution' => $data['resolution'],
                'location' => $data['location'],
                'format' => $data['format'],
                'descriptors' => implode(', ', $faker->words(5)),
                'thumbnail_path' => null,
                'full_image_path' => '/images/photos/' . str_replace(' ', '_', strtolower($data['title'])) . '.jpg',
                'source_type' => 'local',
                'external_url' => null,
                'photographer_id' => Photographer::firstOrCreate(
                    ['full_name' => $data['photographer']],
                    ['slug' => str_replace(' ', '-', strtolower($data['photographer']))]
                )->id,
            ]);

            // Asociar categorías
            foreach ($data['categories'] as $categoryName) {
                $category = Category::where('name', $categoryName)->first();
                if ($category) {
                    $photo->categories()->attach($category->id);
                }
            }
        }
    }
}
