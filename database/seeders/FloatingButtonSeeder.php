<?php

namespace Database\Seeders;

use App\Models\FloatingButton;
use Illuminate\Database\Seeder;

class FloatingButtonSeeder extends Seeder
{
    public function run(): void
    {
        $buttons = [
            [
                'slug'        => 'whatsapp',
                'nombre'      => 'WhatsApp',
                'descripcion' => '',      // Número vacío — el administrador lo completará
                'imagen'      => null,    // QR vacío — el administrador lo subirá
                'logo'        => 'Whatsapp.png',
                'glow_color'  => 'verde',
                'link'        => '',      // Número vacío
                'is_default'  => true,
                'orden'       => 1,
            ],
            [
                'slug'        => 'yape',
                'nombre'      => 'Yape',
                'descripcion' => '',      // Descripción vacía
                'imagen'      => null,    // QR vacío — el administrador lo subirá
                'logo'        => 'Yape.png',
                'glow_color'  => 'morado',
                'link'        => '',
                'is_default'  => true,
                'orden'       => 2,
            ],
        ];

        foreach ($buttons as $data) {
            FloatingButton::firstOrCreate(
                ['slug' => $data['slug']],
                $data
            );
        }
    }
}
