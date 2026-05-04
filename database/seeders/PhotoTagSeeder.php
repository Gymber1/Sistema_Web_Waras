<?php

namespace Database\Seeders;

use App\Models\PhotoTag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PhotoTagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            'Antes del Terremoto',
            'Terremoto',
            'Después del Terremoto',
            'Siglo XXI',
        ];

        foreach ($tags as $tag) {
            PhotoTag::firstOrCreate(
                ['name' => $tag],
                ['slug' => Str::slug($tag)],
            );
        }
    }
}
