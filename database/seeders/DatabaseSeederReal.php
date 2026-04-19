<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeederReal extends Seeder
{
    /**
     * Seed the application's database con DATOS REALES.
     * Este seeder es solo para datos reales, sin ficticios.
     */
    public function run(): void
    {
        // Ejecutar en orden correcto
        $this->call([
            ModuleSeeder::class,          // Módulos base (Biblioteca, Fototeca)
            UserSeederReal::class,        // Admin y moderadores REALES
            CategorySeederReal::class,    // Categorías base REALES
            // Agregar seeders de datos reales aquí
        ]);
    }
}
