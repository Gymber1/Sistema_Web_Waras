<?php

namespace Database\Seeders;

use App\Models\Photo;
use Illuminate\Database\Seeder;

class PhotoSeederReal extends Seeder
{
    /**
     * Agregar FOTOS REALES.
     */
    public function run(): void
    {
        // Ejemplo: si tienes fotos reales, agrega aquí
        /*
        $photo = Photo::create([
            'title' => 'Título Real de la Foto',
            'slug' => 'titulo-real-de-la-foto',
            'description' => 'Descripción de la fotografía...',
            'capture_date' => '2024-06-15',
            'descriptors' => 'palabra1, palabra2, palabra3',
            'thumbnail_path' => '/images/photos/thumbnails/foto.jpg',
            'full_image_path' => '/images/photos/full/foto.jpg',
            'source_type' => 'local', // 'local' o 'external'
            'external_url' => null,
            'photographer_id' => 1, // ID del fotógrafo
        ]);

        // Asociar categorías
        $photo->categories()->attach([1, 2]); // Asociar categorías por ID
        */
    }
}
