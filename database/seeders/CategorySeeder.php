<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // ==========================================
        // BIBLIOTECA (2 niveles: categoría → subcategoría)
        // ==========================================
        $bibliotecaData = [
            'Generalidades'                     => ['Bibliotecas', 'Libros', 'Lectura', 'Organizaciones y Museología', 'Periodismo', 'Sistemas'],
            'Filosofía Y Psicología'             => [],
            'Religión'                           => [],
            'Ciencias Sociales'                  => ['Economía', 'Derecho', 'Administración Pública', 'Educación', 'Transporte', 'Costumbres Y Folklore', 'Sociología y Antropología'],
            'Lenguas'                            => ['Quechua Ancashino'],
            'Ciencias Naturales Y Matemáticas'   => ['Biología (Ecología)', 'Plantas', 'Animales', 'Física'],
            'Ciencias Aplicadas (Tecnología)'    => ['Ciencias Médicas', 'Ingeniería', 'Agricultura', 'Manufacturas', 'Construcciones'],
            'Arte'                               => [],
            'Literatura'                         => ['Poesía Ancashina', 'Narrativa Ancashina', 'Mitos y Leyendas', 'Antologías (varios géneros)', 'Ensayos Ancashinos'],
            'Historia Y Geografía'               => ['Historia Ancashina', 'Geografía Ancashina', 'Biografías Ancashinas', 'Geografía y Viajes'],
        ];

        foreach ($bibliotecaData as $parentName => $children) {
            $parent = Category::firstOrCreate(
                ['name' => $parentName, 'type' => 'biblioteca', 'parent_id' => null],
                ['slug' => $this->uniqueSlug($parentName)],
            );

            foreach ($children as $childName) {
                Category::firstOrCreate(
                    ['name' => $childName, 'type' => 'biblioteca', 'parent_id' => $parent->id],
                    ['slug' => $this->uniqueSlug($childName)],
                );
            }
        }

        // ==========================================
        // FOTOTECA (multi-nivel recursivo)
        // ==========================================
        $fototecaData = [
            'Por Provincias' => [
                'Por Distritos' => [],
                'Por Ciudades'  => [
                    'Panorámica'           => [],
                    'Plaza de Armas y Catedral' => [],
                    'Por Barrios'          => ['Belén', 'San Francisco', 'La Soledad', 'Huarupampa', 'Centenario', 'Nicrupampa'],
                    'Puentes'              => [],
                    'Calles'               => [],
                    'Casas y Edificios'    => [],
                    'Sociedad y cultura'   => ['Instituciones Sociales', 'Instituciones Culturales', 'Instituciones Educativas', 'Deportes', 'Familias'],
                ],
            ],
            'Especiales' => [
                'Desastres en Ancash'                 => ['Aluvión de Huaraz de 1941', 'Aluvión de Chavín de 1945', 'Aluvión de Ranrahirca de 1962', 'Terremoto del 31 de mayo de 1970', 'Aluvión del 31 de mayo de 1970'],
                'Tradiciones y Costumbres de Huaraz'  => ['Fiesta del Señor de Mayo', 'Semana Santa Huaracina', 'Fiesta de Cruces y Carnavales'],
                'Patrimonio Arqueológico Ancashino'   => ['Sechín', 'Chavín', 'Wicahuain', 'Yaino', 'Tumshukaiko'],
                'Parque Nacional Huascarán'           => [
                    'Nevados y Lagunas' => ['Huascarán', 'Alpamayo', 'Artesonraju', 'Cayesh'],
                    'Circuitos'         => [],
                ],
            ],
        ];

        $this->createFototecaCategories($fototecaData, null);
    }

    private function uniqueSlug(string $name): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $i = 2;
        while (Category::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $i++;
        }
        return $slug;
    }

    private function createFototecaCategories(array $categories, ?int $parentId): void
    {
        foreach ($categories as $key => $value) {
            $name = is_string($key) ? $key : $value;

            $category = Category::firstOrCreate(
                ['name' => $name, 'type' => 'fototeca', 'parent_id' => $parentId],
                ['slug' => $this->uniqueSlug($name)],
            );

            if (is_array($value) && count($value) > 0) {
                $this->createFototecaCategories($value, $category->id);
            }
        }
    }
}
