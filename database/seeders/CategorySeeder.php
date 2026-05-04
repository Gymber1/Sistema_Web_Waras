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
        // FOTOTECA (4 niveles: Categoría → Subcategoría → 1er Nivel → 2do Nivel)
        //
        // Estructura:
        //   Nivel 1 (Categoría):    clave raíz del array
        //   Nivel 2 (Subcategoría): clave del array hijo
        //   Nivel 3 (1er Nivel):    clave del array nieto
        //   Nivel 4 (2do Nivel):    valores string en el array bisnieto
        // ==========================================
        $fototecaData = [

            // ── Por Provincias ───────────────────────────────────────────
            'Por Provincias' => [

                'Huaraz' => [
                    'Por Distritos' => [
                        'Huaraz', 'Independencia', 'Cochabamba', 'Colcabamba',
                        'Huanchay', 'Jangas', 'La Libertad', 'Llanganuco',
                        'Olleros', 'Pampas', 'Paro', 'Paucas', 'Piruro',
                        'Ponta', 'Rajan', 'San Cristóbal', 'Taricá',
                    ],
                    'Ciudad de Huaraz' => [
                        'Panorámica', 'Plaza de Armas', 'Catedral', 'Municipalidad',
                        'Mercado Central', 'Barrio Belén', 'Barrio San Francisco',
                        'Barrio La Soledad', 'Barrio Huarupampa', 'Barrio Centenario',
                        'Barrio Nicrupampa', 'Puente Bedoya', 'Puente Quilcay',
                        'Calles del Centro', 'Casas Coloniales', 'Edificios Históricos',
                    ],
                    'Sociedad y Cultura' => [
                        'Instituciones Educativas', 'Instituciones Culturales',
                        'Instituciones Sociales', 'Deportes', 'Familias',
                    ],
                ],

                'Recuay' => [
                    'Por Distritos' => [
                        'Recuay', 'Catac', 'Cotaparaco', 'Huayllapampa',
                        'Llacllin', 'Pampas Chico', 'Pampas Grande',
                        'Pátay', 'Puchun', 'Tapacocha', 'Ticapampa',
                    ],
                    'Ciudad de Recuay' => [
                        'Plaza de Armas', 'Calles Principales',
                    ],
                ],

                'Carhuaz' => [
                    'Por Distritos' => [
                        'Carhuaz', 'Acopampa', 'Amashca', 'Anta',
                        'Ataquero', 'Cochapeti', 'Hualpacanca', 'Marcará',
                        'Pamparak', 'Paucas', 'Shilla', 'Tinco', 'Yungar',
                    ],
                    'Ciudad de Carhuaz' => [
                        'Plaza de Armas', 'Calles Principales',
                    ],
                ],

                'Yungay' => [
                    'Por Distritos' => [
                        'Yungay', 'Cascapara', 'Mancos', 'Matacoto',
                        'Quillo', 'Ranrahirca', 'Shupluy', 'Yanama',
                    ],
                    'Ciudad de Yungay' => [
                        'Plaza de Armas Original (antes 1970)', 'Ciudad Nueva',
                        'Camposanto', 'El Calvario', 'Palmas',
                    ],
                ],

                'Caraz' => [
                    'Por Distritos' => [
                        'Caraz', 'Chacas', 'Huallanca', 'Huaylas',
                        'Mato', 'Pamparomas', 'Pueblo Libre', 'Santa Cruz',
                        'Santo Toribio', 'Yuracmarca',
                    ],
                    'Ciudad de Caraz' => [
                        'Plaza de Armas', 'Calles Principales',
                    ],
                ],

                'Huari' => [
                    'Por Distritos' => [
                        'Huari', 'Anra', 'Cajay', 'Chavín de Huántar',
                        'Huacachi', 'Huacchis', 'Huachis', 'Huantar',
                        'Masin', 'Paucas', 'Ponto', 'Rahuapampa',
                        'Rapayan', 'San Marcos', 'San Pedro de Chana', 'Uco',
                    ],
                    'Ciudad de Huari' => [
                        'Plaza de Armas', 'Calles Principales',
                    ],
                ],

                'Bolognesi' => [
                    'Por Distritos' => [
                        'Chiquián', 'Abelardo Pardo Lezameta', 'Antonio Raymondi',
                        'Aquia', 'Cajacay', 'Canis', 'Colquioc',
                        'Huallanca', 'Huasta', 'Huayllacayán', 'La Primavera',
                        'Mangas', 'Pacllon', 'San Miguel de Corpanqui', 'Ticllos',
                    ],
                    'Ciudad de Chiquián' => [
                        'Plaza de Armas', 'Calles Principales',
                    ],
                ],

                'Ocros' => [
                    'Por Distritos' => [
                        'Ocros', 'Acas', 'Cajamarquilla', 'Carhuapampa',
                        'Cochas', 'Congas', 'Llipa', 'San Cristóbal de Raján',
                        'San Pedro', 'Santiago de Chilcas',
                    ],
                    'Ciudad de Ocros' => [
                        'Plaza de Armas', 'Calles Principales',
                    ],
                ],

                'Sihuas' => [
                    'Por Distritos' => [
                        'Sihuas', 'Acobamba', 'Alfonso Ugarte', 'Cashapampa',
                        'Chingalpo', 'Huayllabamba', 'Quiches', 'Ragash',
                        'San Juan', 'Sicsibamba',
                    ],
                    'Ciudad de Sihuas' => [
                        'Plaza de Armas', 'Calles Principales',
                    ],
                ],

                'Pomabamba' => [
                    'Por Distritos' => [
                        'Pomabamba', 'Huayllan', 'Parobamba', 'Quinuabamba',
                    ],
                    'Ciudad de Pomabamba' => [
                        'Plaza de Armas', 'Calles Principales',
                    ],
                ],

                'Mariscal Luzuriaga' => [
                    'Por Distritos' => [
                        'Piscobamba', 'Casca', 'Eleazar Guzmán Barrón',
                        'Fidel Olivas Escudero', 'Llama', 'Llumpa',
                        'Lucma', 'Musga',
                    ],
                    'Ciudad de Piscobamba' => [
                        'Plaza de Armas', 'Calles Principales',
                    ],
                ],

                'Asunción' => [
                    'Por Distritos' => [
                        'Chacas', 'Acochaca',
                    ],
                    'Ciudad de Chacas' => [
                        'Plaza de Armas', 'Calles Principales',
                    ],
                ],

                'Antonio Raimondi' => [
                    'Por Distritos' => [
                        'Llamellín', 'Acza', 'Chaccho', 'Chingas',
                        'Mirgas', 'San Juan de Rontoy',
                    ],
                    'Ciudad de Llamellín' => [
                        'Plaza de Armas', 'Calles Principales',
                    ],
                ],

                'Carlos Fermín Fitzcarrald' => [
                    'Por Distritos' => [
                        'San Luis', 'San Nicolás', 'Yauya',
                    ],
                    'Ciudad de San Luis' => [
                        'Plaza de Armas', 'Calles Principales',
                    ],
                ],

                'Corongo' => [
                    'Por Distritos' => [
                        'Corongo', 'Aco', 'Bambas', 'Cusca',
                        'La Pampa', 'Pampas', 'Yanac',
                    ],
                    'Ciudad de Corongo' => [
                        'Plaza de Armas', 'Calles Principales',
                    ],
                ],

                'Pallasca' => [
                    'Por Distritos' => [
                        'Cabana', 'Bolognesi', 'Conchucos', 'Huacaschuque',
                        'Huandoval', 'Lacabamba', 'Llapo', 'Pallasca',
                        'Pampas', 'Santa Rosa', 'Tauca',
                    ],
                    'Ciudad de Cabana' => [
                        'Plaza de Armas', 'Calles Principales',
                    ],
                ],

                'Santa' => [
                    'Por Distritos' => [
                        'Chimbote', 'Cáceres del Perú', 'Coishco',
                        'Macate', 'Moro', 'Nepeña', 'Samanco',
                        'Santa', 'Nuevo Chimbote',
                    ],
                    'Ciudad de Chimbote' => [
                        'Puerto de Chimbote', 'Plaza de Armas',
                        'Calles Principales',
                    ],
                ],

                'Casma' => [
                    'Por Distritos' => [
                        'Casma', 'Buena Vista Alta', 'Comandante Noel', 'Yautan',
                    ],
                    'Ciudad de Casma' => [
                        'Plaza de Armas', 'Calles Principales',
                    ],
                ],

                'Huarmey' => [
                    'Por Distritos' => [
                        'Huarmey', 'Cochapeti', 'Culebras', 'Huayan', 'Malvas',
                    ],
                    'Ciudad de Huarmey' => [
                        'Plaza de Armas', 'Calles Principales',
                    ],
                ],

                'Fitzcarrald' => [
                    'Por Distritos' => [
                        'San Luis', 'San Nicolás', 'Yauya',
                    ],
                    'Ciudad de San Luis' => [
                        'Plaza de Armas', 'Calles Principales',
                    ],
                ],
            ],

            // ── Especiales ───────────────────────────────────────────────
            'Especiales' => [

                'Desastres en Ancash' => [
                    'Aluviones' => [
                        'Aluvión de Huaraz 1941', 'Aluvión de Chavín 1945',
                        'Aluvión de Ranrahirca 1962', 'Aluvión del 31 de mayo 1970',
                    ],
                    'Terremotos' => [
                        'Terremoto del 31 de mayo 1970',
                        'Secuelas del Terremoto 1970',
                    ],
                    'Reconstrucción' => [
                        'Reconstrucción de Huaraz', 'Reconstrucción de Yungay',
                        'Plan de Reconstrucción CRYRZA',
                    ],
                ],

                'Tradiciones y Costumbres de Huaraz' => [
                    'Fiestas Religiosas' => [
                        'Fiesta del Señor de Mayo', 'Semana Santa Huaracina',
                        'Fiesta de Cruces', 'Carnavales Huaracinos',
                        'Corpus Christi', 'Navidad y Año Nuevo',
                    ],
                    'Danzas y Música' => [
                        'Shacshas', 'Antihuankas', 'Negritos',
                        'Pallas', 'Chunchos',
                    ],
                    'Costumbres Cotidianas' => [
                        'Mercados Tradicionales', 'Vestimenta Típica',
                        'Gastronomía Ancashina',
                    ],
                ],

                'Patrimonio Arqueológico Ancashino' => [
                    'Chavín de Huántar' => [
                        'Templo de Chavín', 'Galería Subterránea',
                        'Lanzón Monolítico', 'Cabezas Clavas',
                    ],
                    'Sechín' => [
                        'Complejo de Sechín', 'Relieves de Sechín',
                    ],
                    'Otros Sitios' => [
                        'Wicahuain', 'Yaino', 'Tumshukaiko',
                        'Honcopampa', 'Pashash',
                    ],
                ],

                'Parque Nacional Huascarán' => [
                    'Nevados' => [
                        'Huascarán', 'Alpamayo', 'Artesonraju',
                        'Cayesh', 'Chopicalqui', 'Copa', 'Contrahierbas',
                        'Hualcán', 'Pucaranra', 'Santa Cruz',
                    ],
                    'Lagunas' => [
                        'Laguna Parón', 'Laguna Llanganuco', 'Laguna Churup',
                        'Laguna Rajucolta', 'Laguna Cullicocha',
                        'Laguna Palcacocha',
                    ],
                    'Circuitos Trekking' => [
                        'Santa Cruz Trek', 'Huayhuash Circuit',
                        'Laguna 69', 'Base Camp Huascarán',
                    ],
                    'Flora y Fauna' => [
                        'Puya Raimondi', 'Cóndor', 'Venado de Cola Blanca',
                        'Oso de Anteojos', 'Vicuña',
                    ],
                ],

                'Personajes Ilustres de Ancash' => [
                    'Políticos e Intelectuales' => [
                        'Pedro Cochachin (Ukuku)', 'Ezequiel Boza',
                        'Augusto Bernardino Leguía',
                    ],
                    'Deportistas' => [
                        'Teófilo Cubillas (conexión ancashina)',
                    ],
                    'Artistas y Escritores' => [
                        'Marcos Yauri Montero', 'César Vallejo (visitas a Ancash)',
                    ],
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
            // Si la clave es string es un nodo con nombre propio
            // Si el valor es un array con subelementos, seguir recursando
            // Si el valor es un string (índice numérico), es una hoja
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
