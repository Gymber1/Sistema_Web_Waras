<?php

namespace Database\Seeders;

use App\Models\Photographer;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PhotographerSeeder extends Seeder
{
    /**
     * Crear fotógrafos ficticios para la Fototeca.
     */
    public function run(): void
    {
        $faker = Faker::create('es_ES');

        $photographers = [
            'Ricardo Sánchez García',
            'María López Rodríguez',
            'Juan Carlos Martínez',
            'Sofía González Ramírez',
            'Miguel Ángel Fernández',
        ];

        foreach ($photographers as $name) {
            Photographer::create([
                'full_name' => $name,
                'slug' => str_replace(' ', '-', strtolower($name)),
                'birth_date' => $faker->dateTimeBetween('-60 years', '-25 years')->format('Y-m-d'),
                'death_date' => null, // La mayoría vivos para efectos de prueba
                'biography' => $faker->paragraph(4),
                'photo_path' => null,
            ]);
        }
    }
}
