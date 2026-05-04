<?php

namespace Database\Seeders;

use App\Models\Special;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SpecialSeeder extends Seeder
{
    public function run(): void
    {
        $colecciones = [
            'Familia',
            'Paisajes',
            'Ciudad',
            'Sociedad y Cultura',
            'Instituciones Educativas',
            'Deporte',
            'Tradiciones y Costumbres',
        ];

        foreach ($colecciones as $coleccion) {
            Special::firstOrCreate(
                ['slug' => Str::slug($coleccion)],
                ['title' => $coleccion],
            );
        }
    }
}
