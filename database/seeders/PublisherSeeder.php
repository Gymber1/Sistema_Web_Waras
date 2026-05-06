<?php

namespace Database\Seeders;

use App\Models\Publisher;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PublisherSeeder extends Seeder
{
    public function run(): void
    {
        $publishers = [
            [
                'name'        => 'Fondo Editorial Ancash',
                'address'     => 'Huaraz, Áncash, Perú',
                'description' => 'Fondo editorial de la región Áncash dedicado a la publicación y difusión de obras sobre historia, cultura, literatura y ciencias de la región. Dependiente del Gobierno Regional de Áncash.',
                'website'     => 'https://www.regionancash.gob.pe',
            ],
            [
                'name'        => 'Editorial Huaraz',
                'address'     => 'Huaraz, Áncash, Perú',
                'description' => 'Editorial regional con sede en Huaraz, especializada en obras de historia local, geografía ancashina y literatura regional.',
                'website'     => null,
            ],
            [
                'name'        => 'Ediciones Ancashinas',
                'address'     => 'Huaraz, Áncash, Perú',
                'description' => 'Sello editorial independiente dedicado a la publicación de obras de autores ancashinos y estudios sobre el patrimonio cultural de la región.',
                'website'     => null,
            ],
            [
                'name'        => 'Editorial Científica Peruana',
                'address'     => 'Lima, Perú',
                'description' => 'Editorial académica peruana especializada en publicaciones de arqueología, historia y ciencias sociales sobre el Perú prehispánico y colonial.',
                'website'     => null,
            ],
            [
                'name'        => 'Ministerio de Cultura Perú',
                'address'     => 'Lima, Perú',
                'description' => 'Organismo del Estado Peruano encargado de la promoción, protección y difusión del patrimonio cultural. Publica investigaciones sobre historia, arqueología y tradiciones del Perú.',
                'website'     => 'https://www.cultura.gob.pe',
            ],
            [
                'name'        => 'Ministerio de Educación',
                'address'     => 'Lima, Perú',
                'description' => 'Organismo del Estado Peruano que publica materiales educativos, entre ellos gramáticas y vocabularios de lenguas originarias del Perú.',
                'website'     => 'https://www.minedu.gob.pe',
            ],
            [
                'name'        => 'Instituto Geográfico Nacional',
                'address'     => 'Lima, Perú',
                'description' => 'Organismo técnico especializado del Perú responsable de la cartografía nacional, la geografía física y la investigación geoespacial del territorio peruano.',
                'website'     => 'https://www.ign.gob.pe',
            ],
            [
                'name'        => 'Revista Desarrollo Rural',
                'address'     => 'Huaraz, Áncash, Perú',
                'description' => 'Publicación periódica especializada en agricultura andina, sistemas de riego tradicional y desarrollo rural en la región Áncash.',
                'website'     => null,
            ],
            [
                'name'        => 'UNASAM — Universidad Nacional Santiago Antúnez de Mayolo',
                'address'     => 'Huaraz, Áncash, Perú',
                'description' => 'Fondo editorial de la principal universidad pública de la región Áncash, con sede en Huaraz. Publica investigaciones académicas sobre la realidad regional en todas las áreas del conocimiento.',
                'website'     => 'https://www.unasam.edu.pe',
            ],
            [
                'name'        => 'Biblioteca Municipal de Huaraz',
                'address'     => 'Huaraz, Áncash, Perú',
                'description' => 'Institución cultural de la Municipalidad Provincial de Huaraz que alberga y difunde el patrimonio bibliográfico y documental de la región.',
                'website'     => null,
            ],
        ];

        foreach ($publishers as $data) {
            Publisher::firstOrCreate(
                ['name' => $data['name']],
                [
                    'slug'        => Str::slug($data['name']),
                    'description' => $data['description'],
                    'logo_path'   => null,
                    'email'       => null,
                    'website'     => $data['website'],
                    'phone'       => null,
                    'address'     => $data['address'],
                ]
            );
        }
    }
}
