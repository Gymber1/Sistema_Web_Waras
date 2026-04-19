<?php

namespace Database\Seeders;

use App\Models\Module;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    /**
     * Crear los módulos base (Biblioteca, Fototeca) y preparar para módulos futuros.
     * La tabla modules es la clave de escalabilidad del sistema.
     */
    public function run(): void
    {
        Module::create([
            'name' => 'Biblioteca',
            'slug' => 'biblioteca',
            'description' => 'Módulo de gestión de libros y documentos',
            'base_url' => 'http://localhost:8000/biblioteca',
            'is_active' => true,
            'config' => json_encode([
                'cover_required' => false,
                'isbn_required' => false,
                'author_required' => true,
            ]),
        ]);

        Module::create([
            'name' => 'Fototeca',
            'slug' => 'fototeca',
            'description' => 'Módulo de gestión de fotografías y archivos visuales',
            'base_url' => 'http://localhost:8000/fototeca',
            'is_active' => true,
            'config' => json_encode([
                'thumbnail_required' => true,
                'photographer_optional' => true,
            ]),
        ]);

        // Módulos futuros (preparados en la BD sin datos):
        // Musicoteca, Pinacoteca, Efemérides, Catálogo
    }
}
