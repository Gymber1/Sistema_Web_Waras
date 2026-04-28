<?php

namespace Database\Seeders;

use App\Models\Special;
use Illuminate\Database\Seeder;

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
            Special::firstOrCreate(['name' => $coleccion]);
        }
    }
}
