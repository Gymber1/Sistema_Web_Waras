<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            ModuleSeeder::class,       // 1. Módulos del sistema
            UserSeeder::class,         // 2. Admin global + moderadores
            CategorySeeder::class,     // 3. Categorías reales de Biblioteca y Fototeca
            PhotoTagSeeder::class,     // 4. Etiquetas de la Fototeca
            SpecialSeeder::class,      // 5. Colecciones especiales
            PublisherSeeder::class,    // 6. Editoriales
            AuthorSeeder::class,       // 7. Autores
            BookSeeder::class,         // 8. Libros con relaciones
            PhotographerSeeder::class, // 9. Fotógrafos
            PhotoSeeder::class,        // 10. Fotografías con relaciones
            SiteSettingSeeder::class,        // 11. Configuración inicial del sitio
            FloatingButtonSeeder::class,     // 12. Botones flotantes (WhatsApp y Yape)
        ]);
    }
}
