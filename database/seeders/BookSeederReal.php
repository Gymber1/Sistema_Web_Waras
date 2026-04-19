<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;

class BookSeederReal extends Seeder
{
    /**
     * Agregar LIBROS REALES.
     * Estructura de ejemplo para agregar libros reales al sistema.
     */
    public function run(): void
    {
        // Ejemplo de estructura para agregar un libro real:
        /*
        $book = Book::create([
            'title' => 'Título Real del Libro',
            'slug' => 'titulo-real-del-libro',
            'summary' => 'Resumen o descripción del libro...',
            'publication_date' => '2024-01-15',
            'document_type' => 'Libro', // 'Libro', 'Artículo', 'Revista', 'Tesis'
            'isbn' => '978-1234567890',
            'pages' => 300,
            'language' => 'Español',
            'descriptors' => 'palabra clave1, palabra clave2, palabra clave3',
            'provider' => 'Nombre del Proveedor',
            'cover_image_path' => '/images/books/portada.jpg',
            'source_type' => 'external', // 'external', 'pdf', 'none'
            'external_url' => 'https://ejemplo.com/libro',
            'pdf_file_path' => null,
            'publisher_id' => 1, // ID del editor
        ]);

        // Asociar autores
        $book->authors()->attach([1, 2], ['order' => 1]); // Asociar autores por ID

        // Asociar categorías
        $book->categories()->attach([1]); // Asociar categorías por ID
        */
    }
}
