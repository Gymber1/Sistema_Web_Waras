<?php

namespace Database\Seeders;

use App\Models\FloatingButton;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class FloatingButtonSeeder extends Seeder
{
    public function run(): void
    {
        $buttons = [
            [
                'slug'        => 'whatsapp',
                'nombre'      => 'WhatsApp',
                'descripcion' => '',
                'imagen'      => null,
                'logo_source' => 'Whatsapp.png',
                'glow_color'  => 'verde',
                'link'        => '',
                'is_default'  => true,
                'orden'       => 1,
            ],
            [
                'slug'        => 'yape',
                'nombre'      => 'Yape',
                'descripcion' => '',
                'imagen'      => null,
                'logo_source' => 'Yape.png',
                'glow_color'  => 'morado',
                'link'        => '',
                'is_default'  => true,
                'orden'       => 2,
            ],
        ];

        foreach ($buttons as $data) {
            $logoSource = $data['logo_source'];
            unset($data['logo_source']);

            // Copiar logo desde public/ a storage/public/floating/ si existe
            $sourcePath = public_path($logoSource);
            $destPath   = 'floating/' . $logoSource;

            if (file_exists($sourcePath) && !Storage::disk('public')->exists($destPath)) {
                Storage::disk('public')->put($destPath, file_get_contents($sourcePath));
            }

            $data['logo'] = file_exists($sourcePath) ? $destPath : null;

            $btn = FloatingButton::where('slug', $data['slug'])->first();

            if ($btn) {
                // Solo actualizar el logo si actualmente apunta al nombre plano (sin ruta)
                if ($btn->logo === $logoSource || $btn->logo === null) {
                    $btn->logo = $data['logo'];
                    $btn->save();
                }
            } else {
                FloatingButton::create($data);
            }
        }
    }
}
