<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Ejecutar en orden correcto para evitar problemas de integridad referencial
        $this->call([
            ModuleSeeder::class,          // 1. Crear módulos primero
            UserSeeder::class,            // 2. Crear usuarios (admin, moderadores)
            CategorySeeder::class,        // 3. Crear categorías (reutilizables en todos los módulos)
            PublisherSeeder::class,       // 4. Crear editoriales para libros
            AuthorSeeder::class,          // 5. Crear autores
            BookSeeder::class,            // 6. Crear libros con relaciones
            PhotographerSeeder::class,    // 7. Crear fotógrafos
            PhotoSeeder::class,           // 8. Crear fotos con relaciones
        ]);
    }
}
