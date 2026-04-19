<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class AuthorSeeder extends Seeder
{
    /**
     * Crear autores ficticios españoles e hispanoamericanos para la Biblioteca.
     */
    public function run(): void
    {
        $faker = Faker::create('es_ES');

        $authors = [
            'Gabriel García Márquez',
            'Laura Esquivel',
            'Sara Paretsky',
            'Rosa Montero',
            'Javier Marías',
            'Dolores Redondo',
            'Carlos Ruiz Zafón',
            'María Dueñas',
            'Almudena Grandes',
            'Antonio Muñoz Molina',
        ];

        foreach ($authors as $authorName) {
            Author::create([
                'name' => $authorName,
                'slug' => str_replace(' ', '-', strtolower($authorName)),
                'biography' => $faker->paragraph(3),
                'nationality' => 'España/Colombia',
                'email' => null,
                'website' => null,
                'photo_path' => null,
            ]);
        }
    }
}
