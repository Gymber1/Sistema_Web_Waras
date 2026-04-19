<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Crear categorías jerárquicas de prueba.
     * Estas categorías se pueden reutilizar entre módulos (Biblioteca y Fototeca).
     */
    public function run(): void
    {
        // Categorías principales para BIBLIOTECA
        $ficcion = Category::create([
            'name' => 'Ficción',
            'slug' => 'ficcion',
            'type' => 'biblioteca',
            'description' => 'Libros de ficción y narrativa',
        ]);

        Category::create([
            'name' => 'Novela',
            'slug' => 'novela',
            'type' => 'biblioteca',
            'description' => 'Novelas de diversos géneros',
            'parent_id' => $ficcion->id,
        ]);

        Category::create([
            'name' => 'Cuento',
            'slug' => 'cuento',
            'type' => 'biblioteca',
            'description' => 'Cuentos y relatos breves',
            'parent_id' => $ficcion->id,
        ]);

        $noficcion = Category::create([
            'name' => 'No Ficción',
            'slug' => 'no-ficcion',
            'type' => 'biblioteca',
            'description' => 'Libros informativos y de no ficción',
        ]);

        Category::create([
            'name' => 'Historia',
            'slug' => 'historia',
            'type' => 'biblioteca',
            'description' => 'Libros de historia y arqueología',
            'parent_id' => $noficcion->id,
        ]);

        Category::create([
            'name' => 'Ciencia',
            'slug' => 'ciencia',
            'type' => 'biblioteca',
            'description' => 'Libros de ciencia y tecnología',
            'parent_id' => $noficcion->id,
        ]);

        // Categorías principales para FOTOTECA
        $naturaleza = Category::create([
            'name' => 'Naturaleza',
            'slug' => 'naturaleza',
            'type' => 'fototeca',
            'description' => 'Fotografías de paisajes y naturaleza',
        ]);

        Category::create([
            'name' => 'Fauna',
            'slug' => 'fauna',
            'type' => 'fototeca',
            'description' => 'Fotografías de animales',
            'parent_id' => $naturaleza->id,
        ]);

        Category::create([
            'name' => 'Flora',
            'slug' => 'flora',
            'type' => 'fototeca',
            'description' => 'Fotografías de plantas y flores',
            'parent_id' => $naturaleza->id,
        ]);

        $urbana = Category::create([
            'name' => 'Urbana',
            'slug' => 'urbana',
            'type' => 'fototeca',
            'description' => 'Fotografía urbana y arquitectura',
        ]);

        Category::create([
            'name' => 'Arquitectura',
            'slug' => 'arquitectura',
            'type' => 'fototeca',
            'description' => 'Fotografías de edificios y estructuras',
            'parent_id' => $urbana->id,
        ]);

        Category::create([
            'name' => 'Callejera',
            'slug' => 'callejera',
            'type' => 'fototeca',
            'description' => 'Fotografía callejera y vida urbana',
            'parent_id' => $urbana->id,
        ]);
    }
}
