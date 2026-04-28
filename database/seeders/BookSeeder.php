<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Descriptor;
use App\Models\Publisher;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $booksData = [
            [
                'title'            => 'La Poesía de Ancash: Voces Regionales',
                'document_type'    => 'Libro',
                'section'          => 'Biblioteca Digital',
                'isbn'             => '978-9972-1234-56-1',
                'pages'            => 289,
                'language'         => 'Español',
                'publication_date' => '2015-03-15',
                'imprint'          => 'Huaraz: Fondo Editorial Ancash, 2015',
                'summary'          => 'Recopilación de voces poéticas de la región Ancash que refleja la identidad cultural y la diversidad lingüística del territorio ancashino.',
                'authors'          => ['Manuel Robles Alarcón'],
                'categories'       => ['Literatura', 'Poesía Ancashina'],
                'publisher'        => 'Fondo Editorial Ancash',
            ],
            [
                'title'            => 'Historia del Callejón de Huaylas',
                'document_type'    => 'Libro',
                'section'          => 'Biblioteca Digital',
                'isbn'             => '978-9972-5678-90-2',
                'pages'            => 412,
                'language'         => 'Español',
                'publication_date' => '2018-07-20',
                'imprint'          => 'Huaraz: Editorial Huaraz, 2018',
                'summary'          => 'Estudio histórico exhaustivo del Callejón de Huaylas, desde sus orígenes prehispánicos hasta la reconstrucción posterior al terremoto de 1970.',
                'authors'          => ['Dr. Julio Cortés Huamán'],
                'categories'       => ['Historia Y Geografía', 'Historia Ancashina'],
                'publisher'        => 'Editorial Huaraz',
            ],
            [
                'title'            => 'Chavín de Huántar: Arqueología y Misterio',
                'document_type'    => 'Libro',
                'section'          => 'Biblioteca Digital',
                'isbn'             => '978-9972-9876-54-3',
                'pages'            => 356,
                'language'         => 'Español',
                'publication_date' => '2016-11-05',
                'imprint'          => 'Lima: Editorial Científica Peruana, 2016',
                'summary'          => 'Investigación arqueológica sobre el complejo ceremonial de Chavín de Huántar, sus galerías subterráneas, iconografía y su rol en los Andes centrales.',
                'authors'          => ['Dra. Rosario Vidal García', 'Prof. Carlos Mendoza Silva'],
                'categories'       => ['Ciencias Naturales Y Matemáticas', 'Historia Y Geografía'],
                'publisher'        => 'Editorial Científica Peruana',
            ],
            [
                'title'            => 'Mitos y Leyendas del Huascarán',
                'document_type'    => 'Libro',
                'section'          => 'Biblioteca Digital',
                'isbn'             => '978-9972-1111-22-4',
                'pages'            => 234,
                'language'         => 'Español',
                'publication_date' => '2019-02-10',
                'imprint'          => 'Huaraz: Ediciones Ancashinas, 2019',
                'summary'          => 'Compilación de mitos y leyendas transmitidas oralmente en las comunidades andinas de Ancash, relacionadas con el nevado Huascarán y las fuerzas de la naturaleza.',
                'authors'          => ['Isabel Flores Morales'],
                'categories'       => ['Literatura', 'Mitos y Leyendas'],
                'publisher'        => 'Ediciones Ancashinas',
            ],
            [
                'title'            => 'Terremoto de 1970: Testimonios de la Tragedia',
                'document_type'    => 'Libro',
                'section'          => 'Biblioteca Digital',
                'isbn'             => '978-9972-3333-44-5',
                'pages'            => 501,
                'language'         => 'Español',
                'publication_date' => '2020-05-22',
                'imprint'          => 'Lima: Ministerio de Cultura Perú, 2020',
                'summary'          => 'Testimonios directos de sobrevivientes del terremoto del 31 de mayo de 1970, junto con un análisis histórico y social de su impacto en la región Ancash.',
                'authors'          => ['Prof. Enrique Beltrán Cruz', 'Ing. Miguel Fernández López'],
                'categories'       => ['Historia Y Geografía', 'Historia Ancashina'],
                'publisher'        => 'Ministerio de Cultura Perú',
            ],
            [
                'title'            => 'Técnicas Agrícolas Tradicionales de Ancash',
                'document_type'    => 'Artículo',
                'section'          => 'Biblioteca Digital',
                'isbn'             => null,
                'pages'            => 128,
                'language'         => 'Español',
                'publication_date' => '2021-01-15',
                'imprint'          => 'Huaraz: Revista Desarrollo Rural, 2021',
                'summary'          => 'Análisis de las técnicas agrícolas ancestrales usadas en los valles interandinos de Ancash, incluyendo sistemas de andenería y manejo del agua.',
                'authors'          => ['Ing. Agr. Roberto Puma Delgado'],
                'categories'       => ['Ciencias Aplicadas (Tecnología)', 'Agricultura'],
                'publisher'        => 'Revista Desarrollo Rural',
            ],
            [
                'title'            => 'Geografía Física de Ancash',
                'document_type'    => 'Libro',
                'section'          => 'Biblioteca Digital',
                'isbn'             => '978-9972-7777-88-7',
                'pages'            => 320,
                'language'         => 'Español',
                'publication_date' => '2014-08-12',
                'imprint'          => 'Lima: Instituto Geográfico Nacional, 2014',
                'summary'          => 'Descripción detallada de la geografía física de Ancash: cordilleras, valles, ríos, clima y los recursos naturales del departamento.',
                'authors'          => ['Dr. Alfredo Ramírez Quispe'],
                'categories'       => ['Historia Y Geografía', 'Geografía Ancashina'],
                'publisher'        => 'Instituto Geográfico Nacional',
            ],
            [
                'title'            => 'Costumbres y Folklore Ancashino',
                'document_type'    => 'Libro',
                'section'          => 'Biblioteca Digital',
                'isbn'             => '978-9972-2222-33-8',
                'pages'            => 275,
                'language'         => 'Español',
                'publication_date' => '2017-04-18',
                'imprint'          => 'Huaraz: Fondo Editorial Ancash, 2017',
                'summary'          => 'Documentación etnográfica de las festividades, danzas, música y costumbres de las provincias de Ancash, con especial énfasis en las tradiciones de Huaraz.',
                'authors'          => ['Lic. Carmen Sánchez Villanueva'],
                'categories'       => ['Ciencias Sociales', 'Costumbres Y Folklore'],
                'publisher'        => 'Fondo Editorial Ancash',
            ],
            [
                'title'            => 'Quechua Ancashino: Gramática y Vocabulario',
                'document_type'    => 'Libro',
                'section'          => 'Biblioteca Digital',
                'isbn'             => '978-9972-4444-55-9',
                'pages'            => 198,
                'language'         => 'Español / Quechua',
                'publication_date' => '2013-10-30',
                'imprint'          => 'Lima: Ministerio de Educación, 2013',
                'summary'          => 'Guía gramatical y léxica del quechua ancashino, variante regional del quechua con características propias del norte chico andino.',
                'authors'          => ['Prof. Teófilo Laime Huanca'],
                'categories'       => ['Lenguas', 'Quechua Ancashino'],
                'publisher'        => 'Ministerio de Educación',
            ],
            [
                'title'            => 'Biografías Ancashinas: Héroes y Pensadores',
                'document_type'    => 'Libro',
                'section'          => 'Waras Editorial',
                'isbn'             => '978-9972-6666-77-0',
                'pages'            => 340,
                'language'         => 'Español',
                'publication_date' => '2022-03-05',
                'imprint'          => 'Huaraz: Ediciones Ancashinas, 2022',
                'summary'          => 'Semblanzas biográficas de personajes ilustres nacidos en Ancash: intelectuales, políticos, artistas y científicos que han marcado la historia del Perú.',
                'authors'          => ['Dr. Julio Cortés Huamán', 'Lic. Carmen Sánchez Villanueva'],
                'categories'       => ['Historia Y Geografía', 'Biografías Ancashinas'],
                'publisher'        => 'Ediciones Ancashinas',
            ],
        ];

        foreach ($booksData as $data) {
            $book = Book::create([
                'title'            => $data['title'],
                'slug'             => Str::slug($data['title']),
                'summary'          => $data['summary'],
                'imprint'          => $data['imprint'],
                'publication_date' => $data['publication_date'],
                'document_type'    => $data['document_type'],
                'section'          => $data['section'],
                'isbn'             => $data['isbn'],
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
