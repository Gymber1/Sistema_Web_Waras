<?php

namespace Database\Seeders;

use App\Models\Publisher;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PublisherSeeder extends Seeder
{
    /**
     * Crear editoriales españolas ficticias para poblar la Biblioteca.
     */
    public function run(): void
    {
        $faker = Faker::create('es_ES');

        $editorials = [
            ['name' => 'Editorial Planeta', 'city' => 'Barcelona'],
            ['name' => 'Penguin Random House', 'city' => 'Madrid'],
            ['name' => 'Alfaguara', 'city' => 'Madrid'],
            ['name' => 'Minotauro', 'city' => 'Barcelona'],
            ['name' => 'Ediciones B', 'city' => 'Barcelona'],
        ];

        foreach ($editorials as $editorial) {
            Publisher::create([
                'name' => $editorial['name'],
                'slug' => str_replace(' ', '-', strtolower($editorial['name'])),
                'description' => $faker->paragraph(),
                'logo_path' => null,
                'email' => strtolower(str_replace(' ', '.', $editorial['name'])) . '@editorial.es',
                'website' => 'https://www.' . strtolower(str_replace(' ', '', $editorial['name'])) . '.es',
                'phone' => $faker->phoneNumber(),
                'address' => $editorial['city'] . ', España',
            ]);
        }
    }
}
