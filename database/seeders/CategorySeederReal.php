<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeederReal extends Seeder
{
    /**
     * Crear solo categorías REALES que se usarán en el sistema.
     * Sin categorías ficticias de prueba.
     */
    public function run(): void
    {
        // Categorías principales por módulo
        
        // === BIBLIOTECA ===
        $ficcion = Category::create([
            'name' => 'Ficción',
            'slug' => 'ficcion',
            'description' => 'Obras de ficción literaria',
        ]);

        $noficcion = Category::create([
            'name' => 'No Ficción',
            'slug' => 'no-ficcion',
            'description' => 'Obras de estructura no ficcional (ensayos, historia, biografía)',
        ]);

        // === FOTOTECA ===
        $naturaleza = Category::create([
            'name' => 'Naturaleza',
            'slug' => 'naturaleza',
            'description' => 'Fotografías de espacios naturales',
        ]);

        $arquitectura = Category::create([
            'name' => 'Arquitectura',
            'slug' => 'arquitectura',
            'description' => 'Fotografías de edificios y estructuras',
        ]);

        $documental = Category::create([
            'name' => 'Documental',
            'slug' => 'documental',
            'description' => 'Fotografía documental y social',
        ]);
    }
}
