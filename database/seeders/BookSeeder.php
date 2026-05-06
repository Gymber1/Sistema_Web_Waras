<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Publisher;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $booksData = [
            // ── LITERATURA ─────────────────────────────────────────────
            [
                'title'            => 'La Poesía de Ancash: Voces Regionales',
                'document_type'    => 'Libro',
                'section'          => 'Biblioteca Digital',
                'isbn'             => '978-9972-1234-56-1',
                'pages'            => 289,
                'language'         => 'Español',
                'publication_year' => 2015,
                'city'             => 'Huaraz',
                'editorial_name'   => 'Fondo Editorial Ancash',
                'summary'          => 'Recopilación de voces poéticas de la región Áncash que refleja la identidad cultural y la diversidad lingüística del territorio ancashino. Incluye poemas en español y quechua ancashino.',
                'authors'          => ['Manuel Robles Alarcón'],
                'categories'       => ['Literatura', 'Poesía Ancashina'],
                'publisher'        => 'Fondo Editorial Ancash',
            ],
            [
                'title'            => 'Mitos y Leyendas del Huascarán',
                'document_type'    => 'Libro',
                'section'          => 'Biblioteca Digital',
                'isbn'             => '978-9972-1111-22-4',
                'pages'            => 234,
                'language'         => 'Español',
                'publication_year' => 2019,
                'city'             => 'Huaraz',
                'editorial_name'   => 'Ediciones Ancashinas',
                'summary'          => 'Compilación de mitos y leyendas transmitidas oralmente en las comunidades andinas de Áncash, relacionadas con el nevado Huascarán, las lagunas glaciares y las fuerzas de la naturaleza.',
                'authors'          => ['Isabel Flores Morales'],
                'categories'       => ['Literatura', 'Mitos y Leyendas'],
                'publisher'        => 'Ediciones Ancashinas',
            ],
            [
                'title'            => 'Narrativa Ancashina Contemporánea',
                'document_type'    => 'Libro',
                'section'          => 'Waras Editorial',
                'isbn'             => '978-9972-8888-11-5',
                'pages'            => 312,
                'language'         => 'Español',
                'publication_year' => 2021,
                'city'             => 'Huaraz',
                'editorial_name'   => 'Ediciones Ancashinas',
                'summary'          => 'Antología de cuentos y relatos de autores ancashinos contemporáneos que exploran la identidad, la memoria y los cambios sociales en la región Áncash del siglo XXI.',
                'authors'          => ['Marcos Yauri Montero', 'Isabel Flores Morales'],
                'categories'       => ['Literatura', 'Narrativa Ancashina'],
                'publisher'        => 'Ediciones Ancashinas',
            ],
            // ── HISTORIA ───────────────────────────────────────────────
            [
                'title'            => 'Historia del Callejón de Huaylas',
                'document_type'    => 'Libro',
                'section'          => 'Biblioteca Digital',
                'isbn'             => '978-9972-5678-90-2',
                'pages'            => 412,
                'language'         => 'Español',
                'publication_year' => 2018,
                'city'             => 'Huaraz',
                'editorial_name'   => 'Editorial Huaraz',
                'summary'          => 'Estudio histórico exhaustivo del Callejón de Huaylas, desde sus orígenes prehispánicos hasta la reconstrucción posterior al terremoto de 1970. Incluye fuentes primarias y testimonios orales.',
                'authors'          => ['Dr. Julio Cortés Huamán'],
                'categories'       => ['Historia Y Geografía', 'Historia Ancashina'],
                'publisher'        => 'Editorial Huaraz',
            ],
            [
                'title'            => 'Terremoto de 1970: Testimonios de la Tragedia',
                'document_type'    => 'Libro',
                'section'          => 'Biblioteca Digital',
                'isbn'             => '978-9972-3333-44-5',
                'pages'            => 501,
                'language'         => 'Español',
                'publication_year' => 2020,
                'city'             => 'Lima',
                'editorial_name'   => 'Ministerio de Cultura Perú',
                'summary'          => 'Testimonios directos de sobrevivientes del terremoto del 31 de mayo de 1970, junto con un análisis histórico y social de su impacto en la región Áncash. Incluye fotografías históricas y documentos oficiales.',
                'authors'          => ['Prof. Enrique Beltrán Cruz', 'Ing. Miguel Fernández López'],
                'categories'       => ['Historia Y Geografía', 'Historia Ancashina'],
                'publisher'        => 'Ministerio de Cultura Perú',
            ],
            [
                'title'            => 'Biografías Ancashinas: Héroes y Pensadores',
                'document_type'    => 'Libro',
                'section'          => 'Waras Editorial',
                'isbn'             => '978-9972-6666-77-0',
                'pages'            => 340,
                'language'         => 'Español',
                'publication_year' => 2022,
                'city'             => 'Huaraz',
                'editorial_name'   => 'Ediciones Ancashinas',
                'summary'          => 'Semblanzas biográficas de personajes ilustres nacidos en Áncash: intelectuales, políticos, artistas y científicos que han marcado la historia del Perú.',
                'authors'          => ['Dr. Julio Cortés Huamán', 'Lic. Carmen Sánchez Villanueva'],
                'categories'       => ['Historia Y Geografía', 'Biografías Ancashinas'],
                'publisher'        => 'Ediciones Ancashinas',
            ],
            [
                'title'            => 'Cronología de Huaraz: Del Período Prehispánico al Siglo XX',
                'document_type'    => 'Libro',
                'section'          => 'Biblioteca Digital',
                'isbn'             => '978-9972-4321-00-6',
                'pages'            => 380,
                'language'         => 'Español',
                'publication_year' => 2016,
                'city'             => 'Huaraz',
                'editorial_name'   => 'Fondo Editorial Ancash',
                'summary'          => 'Cronología detallada de los principales eventos históricos ocurridos en la ciudad de Huaraz y la provincia, desde los asentamientos prehispánicos hasta los procesos de modernización del siglo XX.',
                'authors'          => ['Augusto Alba Herrera'],
                'categories'       => ['Historia Y Geografía', 'Historia Ancashina'],
                'publisher'        => 'Fondo Editorial Ancash',
            ],
            // ── ARQUEOLOGÍA ────────────────────────────────────────────
            [
                'title'            => 'Chavín de Huántar: Arqueología y Misterio',
                'document_type'    => 'Libro',
                'section'          => 'Biblioteca Digital',
                'isbn'             => '978-9972-9876-54-3',
                'pages'            => 356,
                'language'         => 'Español',
                'publication_year' => 2016,
                'city'             => 'Lima',
                'editorial_name'   => 'Editorial Científica Peruana',
                'summary'          => 'Investigación arqueológica sobre el complejo ceremonial de Chavín de Huántar, sus galerías subterráneas, iconografía y su rol como centro de poder en los Andes centrales entre 1200 y 200 a.C.',
                'authors'          => ['Dra. Rosario Vidal García', 'Prof. Carlos Mendoza Silva'],
                'categories'       => ['Historia Y Geografía', 'Historia Ancashina'],
                'publisher'        => 'Editorial Científica Peruana',
            ],
            // ── GEOGRAFÍA ──────────────────────────────────────────────
            [
                'title'            => 'Geografía Física de Ancash',
                'document_type'    => 'Libro',
                'section'          => 'Biblioteca Digital',
                'isbn'             => '978-9972-7777-88-7',
                'pages'            => 320,
                'language'         => 'Español',
                'publication_year' => 2014,
                'city'             => 'Lima',
                'editorial_name'   => 'Instituto Geográfico Nacional',
                'summary'          => 'Descripción detallada de la geografía física de Áncash: Cordillera Blanca, Cordillera Negra, valles interandinos, ríos, clima y recursos naturales del departamento.',
                'authors'          => ['Dr. Alfredo Ramírez Quispe'],
                'categories'       => ['Historia Y Geografía', 'Geografía Ancashina'],
                'publisher'        => 'Instituto Geográfico Nacional',
            ],
            [
                'title'            => 'Los Glaciares de la Cordillera Blanca',
                'document_type'    => 'Libro',
                'section'          => 'Biblioteca Digital',
                'isbn'             => '978-9972-5555-66-8',
                'pages'            => 280,
                'language'         => 'Español',
                'publication_year' => 2023,
                'city'             => 'Huaraz',
                'editorial_name'   => 'UNASAM — Universidad Nacional Santiago Antúnez de Mayolo',
                'summary'          => 'Estudio actualizado sobre el retroceso glaciar en la Cordillera Blanca y su impacto en los recursos hídricos de Áncash. Incluye datos de monitoreo de los últimos cincuenta años y proyecciones al 2050.',
                'authors'          => ['Dr. Alfredo Ramírez Quispe'],
                'categories'       => ['Ciencias Naturales Y Matemáticas', 'Biología (Ecología)'],
                'publisher'        => 'UNASAM — Universidad Nacional Santiago Antúnez de Mayolo',
            ],
            // ── LENGUAS ────────────────────────────────────────────────
            [
                'title'            => 'Quechua Ancashino: Gramática y Vocabulario',
                'document_type'    => 'Libro',
                'section'          => 'Biblioteca Digital',
                'isbn'             => '978-9972-4444-55-9',
                'pages'            => 198,
                'language'         => 'Español / Quechua',
                'publication_year' => 2013,
                'city'             => 'Lima',
                'editorial_name'   => 'Ministerio de Educación',
                'summary'          => 'Guía gramatical y léxica del quechua ancashino, variante del quechua hablada en la sierra de Áncash. Incluye fonología, morfología, sintaxis y un vocabulario español-quechua de más de dos mil entradas.',
                'authors'          => ['Prof. Teófilo Laime Huanca'],
                'categories'       => ['Lenguas', 'Quechua Ancashino'],
                'publisher'        => 'Ministerio de Educación',
            ],
            // ── CIENCIAS SOCIALES ──────────────────────────────────────
            [
                'title'            => 'Costumbres y Folklore Ancashino',
                'document_type'    => 'Libro',
                'section'          => 'Biblioteca Digital',
                'isbn'             => '978-9972-2222-33-8',
                'pages'            => 275,
                'language'         => 'Español',
                'publication_year' => 2017,
                'city'             => 'Huaraz',
                'editorial_name'   => 'Fondo Editorial Ancash',
                'summary'          => 'Documentación etnográfica de las festividades, danzas, música y costumbres de las provincias de Áncash, con especial énfasis en las tradiciones de Huaraz: Semana Santa, Fiesta del Señor de Mayo y Carnavales.',
                'authors'          => ['Lic. Carmen Sánchez Villanueva'],
                'categories'       => ['Ciencias Sociales', 'Costumbres Y Folklore'],
                'publisher'        => 'Fondo Editorial Ancash',
            ],
            // ── CIENCIAS APLICADAS ─────────────────────────────────────
            [
                'title'            => 'Técnicas Agrícolas Tradicionales de Ancash',
                'document_type'    => 'Artículo',
                'section'          => 'Biblioteca Digital',
                'isbn'             => null,
                'pages'            => 128,
                'language'         => 'Español',
                'publication_year' => 2021,
                'city'             => 'Huaraz',
                'editorial_name'   => 'Revista Desarrollo Rural',
                'summary'          => 'Análisis de las técnicas agrícolas ancestrales usadas en los valles interandinos de Áncash: sistemas de andenería, canales de riego prehispánicos, rotación de cultivos y variedades nativas de papa y maíz.',
                'authors'          => ['Ing. Agr. Roberto Puma Delgado'],
                'categories'       => ['Ciencias Aplicadas (Tecnología)', 'Agricultura'],
                'publisher'        => 'Revista Desarrollo Rural',
            ],
            // ── REVISTAS ───────────────────────────────────────────────
            [
                'title'            => 'Boletín del Instituto de Estudios Ancashinos — N° 12',
                'document_type'    => 'Revista',
                'section'          => 'Biblioteca Digital',
                'isbn'             => null,
                'pages'            => 96,
                'language'         => 'Español',
                'publication_year' => 2022,
                'city'             => 'Huaraz',
                'editorial_name'   => 'UNASAM — Universidad Nacional Santiago Antúnez de Mayolo',
                'summary'          => 'Número 12 del boletín periódico del Instituto de Estudios Ancashinos, con artículos sobre arqueología, historia regional, lingüística quechua y patrimonio natural de Áncash.',
                'authors'          => ['Dr. Julio Cortés Huamán', 'Prof. Teófilo Laime Huanca'],
                'categories'       => ['Historia Y Geografía', 'Historia Ancashina'],
                'publisher'        => 'UNASAM — Universidad Nacional Santiago Antúnez de Mayolo',
            ],
            [
                'title'            => 'Revista Ancash Cultural — Edición Especial Terremoto 1970',
                'document_type'    => 'Revista',
                'section'          => 'Biblioteca Digital',
                'isbn'             => null,
                'pages'            => 120,
                'language'         => 'Español',
                'publication_year' => 2020,
                'city'             => 'Huaraz',
                'editorial_name'   => 'Biblioteca Municipal de Huaraz',
                'summary'          => 'Edición especial de la revista cultural ancashina dedicada a los cincuenta años del terremoto del 31 de mayo de 1970. Reúne testimonios, fotografías históricas, análisis del impacto urbanístico y homenajes a las víctimas.',
                'authors'          => ['Prof. Enrique Beltrán Cruz', 'Augusto Alba Herrera'],
                'categories'       => ['Historia Y Geografía', 'Historia Ancashina'],
                'publisher'        => 'Biblioteca Municipal de Huaraz',
            ],
        ];

        foreach ($booksData as $data) {
            $book = Book::create([
                'title'            => $data['title'],
                'slug'             => Str::slug($data['title']),
                'summary'          => $data['summary'],
                'city'             => $data['city'],
                'editorial_name'   => $data['editorial_name'],
                'publication_year' => $data['publication_year'],
                'imprint'          => $data['city'] . ': ' . $data['editorial_name'] . ', ' . $data['publication_year'],
                'document_type'    => $data['document_type'],
                'section'          => $data['section'],
                'isbn'             => $data['isbn'] ?? null,
                'pages'            => $data['pages'],
                'language'         => $data['language'],
                'provider'         => 'Biblioteca WARAS',
                'cover_image_path' => null,
                'source_type'      => 'none',
                'external_url'     => null,
                'pdf_file_path'    => null,
                'publisher_id'     => Publisher::where('name', $data['publisher'])->first()?->id,
            ]);

            foreach ($data['authors'] as $authorName) {
                $author = Author::firstOrCreate(
                    ['name' => $authorName],
                    ['slug' => Str::slug($authorName)]
                );
                $book->authors()->attach($author->id, ['order' => 1]);
            }

            foreach ($data['categories'] as $categoryName) {
                $category = Category::where('name', $categoryName)->where('type', 'biblioteca')->first();
                if ($category) {
                    $book->categories()->attach($category->id);
                }
            }
        }
    }
}
