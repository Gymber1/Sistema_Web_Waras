<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Author;
use App\Models\Publisher;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class BookSeeder extends Seeder
{
    /**
     * Crear al menos 5 libros con todas las relaciones (autores, categorías).
     * Demuestra la escalabilidad del sistema.
     */
    public function run(): void
    {
        $faker = Faker::create('es_ES');

        $books_data = [
            [
                'title' => 'La Poesía de Ancash: Voces Regionales',
                'document_type' => 'Libro',
                'isbn' => '978-9972-1234-56-1',
                'pages' => 289,
                'language' => 'Español',
                'publication_date' => '2015-03-15',
                'authors' => ['Manuel Robles Alarcón'],
                'categories' => ['Literatura', 'Poesía'],
                'publisher' => 'Fondo Editorial Ancash',
            ],
            [
                'title' => 'Historia del Callejón de Huaylas',
                'document_type' => 'Libro',
                'isbn' => '978-9972-5678-90-2',
                'pages' => 412,
                'language' => 'Español',
                'publication_date' => '2018-07-20',
                'authors' => ['Dr. Julio Cortés Huamán'],
                'categories' => ['Historia Y Geografía', 'Historia'],
                'publisher' => 'Editorial Huaraz',
            ],
            [
                'title' => 'Chavín de Huántar: Arqueología y Misterio',
                'document_type' => 'Libro',
                'isbn' => '978-9972-9876-54-3',
                'pages' => 356,
                'language' => 'Español',
                'publication_date' => '2016-11-05',
                'authors' => ['Dra. Rosario Vidal García', 'Prof. Carlos Mendoza Silva'],
                'categories' => ['Ciencia y Tecnología', 'Arqueología'],
                'publisher' => 'Editorial Científica Peruana',
            ],
            [
                'title' => 'Las Leyendas del Huascarán',
                'document_type' => 'Libro',
                'isbn' => '978-9972-1111-22-4',
                'pages' => 234,
                'language' => 'Español',
                'publication_date' => '2019-02-10',
                'authors' => ['Isabel Flores Morales'],
                'categories' => ['Literatura', 'Cuento'],
                'publisher' => 'Ediciones Ancashinas',
            ],
            [
                'title' => 'Terremoto de 1970: Testimonios de la Tragedia',
                'document_type' => 'Libro',
                'isbn' => '978-9972-3333-44-5',
                'pages' => 501,
                'language' => 'Español',
                'publication_date' => '2020-05-22',
                'authors' => ['Prof. Enrique Beltrán Cruz', 'Ing. Miguel Fernández López'],
                'categories' => ['Historia Y Geografía', 'Desastres'],
                'publisher' => 'Ministerio de Cultura Perú',
            ],
            [
                'title' => 'Técnicas Agrícolas Tradicionales de Ancash',
                'document_type' => 'Artículo',
                'isbn' => null,
                'pages' => 128,
                'language' => 'Español',
                'publication_date' => '2021-01-15',
                'authors' => ['Ing. Agr. Roberto Puma Delgado'],
                'categories' => ['Ciencia y Tecnología', 'Agricultura'],
                'publisher' => 'Revista Desarrollo Rural',
            ],
            [
                'title' => 'Confecciones Textiles de Ancash: Arte y Tradición',
                'document_type' => 'Revista',
                'isbn' => null,
                'pages' => 64,
                'language' => 'Español',
                'publication_date' => '2022-06-01',
                'authors' => ['Colectivo de Artesanos Ancashinos'],
                'categories' => ['Ciencia y Tecnología', 'Artesanía'],
                'publisher' => 'Instituto Intercultural Andino',
            ],
            [
                'title' => 'La Cordillera Blanca: Flora y Fauna Endémica',
                'document_type' => 'Libro',
                'isbn' => '978-9972-5555-66-6',
                'pages' => 378,
                'language' => 'Español',
                'publication_date' => '2017-09-08',
                'authors' => ['Dr. Alfredo Ramírez Quispe'],
                'categories' => ['Ciencia y Tecnología', 'Biodiversidad'],
                'publisher' => 'Servicio Nacional de Áreas Protegidas',
            ],
        ];

        foreach ($books_data as $data) {
            $book = Book::create([
                'title' => $data['title'],
                'slug' => str_replace(' ', '-', strtolower($data['title'])),
                'summary' => $faker->paragraph(5),
                'publication_date' => $data['publication_date'],
                'document_type' => $data['document_type'],
                'isbn' => $data['isbn'],
                'pages' => $data['pages'],
                'language' => $data['language'],
                'descriptors' => implode(', ', $faker->words(5)),
                'provider' => 'Fototeca WARAS',
                'cover_image_path' => null,
                'source_type' => 'none',
                'external_url' => null,
                'pdf_file_path' => null,
                'publisher_id' => Publisher::where('name', $data['publisher'])->first()?->id,
            ]);

            // Asociar autores
            foreach ($data['authors'] as $authorName) {
                $author = Author::firstOrCreate(
                    ['name' => $authorName],
                    ['slug' => str_replace(' ', '-', strtolower($authorName))]
                );
                $book->authors()->attach($author->id, ['order' => 1]);
            }

            // Asociar categorías
            foreach ($data['categories'] as $categoryName) {
                $category = Category::where('name', $categoryName)->first();
                if ($category) {
                    $book->categories()->attach($category->id);
                }
            }
        }
    }
}
