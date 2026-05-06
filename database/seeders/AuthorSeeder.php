<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AuthorSeeder extends Seeder
{
    public function run(): void
    {
        $authors = [
            [
                'name'        => 'Marcos Yauri Montero',
                'nationality' => 'Peruana',
                'biography'   => 'Escritor, lingüista y folklorista ancashino nacido en Llamellín en 1930. Considerado uno de los más importantes narradores regionales del Perú, sus obras exploran la identidad cultural andina, los mitos y la cosmovisión quechua de Áncash. Fue docente universitario y miembro de la Academia Peruana de la Lengua.',
            ],
            [
                'name'        => 'Augusto Alba Herrera',
                'nationality' => 'Peruana',
                'biography'   => 'Historiador y cronista huaracino, autor de numerosas obras sobre la historia de Huaraz y el Callejón de Huaylas. Sus investigaciones sobre el período colonial ancashino son referencia obligada para los estudios regionales.',
            ],
            [
                'name'        => 'Prof. Teófilo Laime Huanca',
                'nationality' => 'Peruana',
                'biography'   => 'Lingüista especializado en el quechua ancashino (quechua del norte). Ha publicado gramáticas, vocabularios y textos pedagógicos para la preservación y enseñanza de la lengua quechua en la región Áncash.',
            ],
            [
                'name'        => 'Dr. Julio Cortés Huamán',
                'nationality' => 'Peruana',
                'biography'   => 'Historiador y docente universitario natural de Huaraz. Sus investigaciones abarcan la historia prehispánica, colonial y republicana de Áncash, con especial énfasis en el impacto social del terremoto de 1970 y los procesos de reconstrucción.',
            ],
            [
                'name'        => 'Dra. Rosario Vidal García',
                'nationality' => 'Peruana',
                'biography'   => 'Arqueóloga peruana especializada en la cultura Chavín y los procesos formativos de los Andes centrales. Ha participado en numerosas temporadas de excavación en Chavín de Huántar y Sechín.',
            ],
            [
                'name'        => 'Lic. Carmen Sánchez Villanueva',
                'nationality' => 'Peruana',
                'biography'   => 'Etnóloga y folklorista ancashina, investigadora de las tradiciones orales, danzas y festividades de las provincias de Áncash. Colaboradora del Ministerio de Cultura del Perú en proyectos de patrimonio intangible.',
            ],
            [
                'name'        => 'Prof. Enrique Beltrán Cruz',
                'nationality' => 'Peruana',
                'biography'   => 'Docente e historiador natural de Yungay, sobreviviente del aluvión de 1970. Ha dedicado su obra académica a documentar los testimonios de las víctimas y el proceso de reconstrucción de Yungay y el Callejón de Huaylas.',
            ],
            [
                'name'        => 'Dr. Alfredo Ramírez Quispe',
                'nationality' => 'Peruana',
                'biography'   => 'Geógrafo y ecólogo ancashino, especialista en la dinámica de los glaciares de la Cordillera Blanca y los recursos hídricos de Áncash. Investigador del Instituto Geográfico Nacional del Perú.',
            ],
            [
                'name'        => 'Ing. Agr. Roberto Puma Delgado',
                'nationality' => 'Peruana',
                'biography'   => 'Ingeniero agrónomo y etnobotánico, especialista en los sistemas agrícolas tradicionales andinos de Áncash, incluyendo la andenería, los sistemas de riego y los cultivos nativos del Callejón de Huaylas.',
            ],
            [
                'name'        => 'Isabel Flores Morales',
                'nationality' => 'Peruana',
                'biography'   => 'Escritora y recopiladora de tradición oral andina, natural de Carhuaz. Sus obras recogen mitos, leyendas y cuentos transmitidos por comunidades campesinas de Áncash, con especial atención a las narrativas vinculadas al nevado Huascarán.',
            ],
            [
                'name'        => 'Manuel Robles Alarcón',
                'nationality' => 'Peruana',
                'biography'   => 'Poeta y ensayista huaracino. Su obra lírica explora la identidad ancashina desde una perspectiva contemporánea que dialoga con la tradición quechua y la memoria histórica de la región.',
            ],
            [
                'name'        => 'Ing. Miguel Fernández López',
                'nationality' => 'Peruana',
                'biography'   => 'Ingeniero civil e historiador de la reconstrucción post-sísmica de Áncash. Ha documentado los proyectos urbanísticos ejecutados por el organismo CRYRZA entre 1970 y 1980.',
            ],
        ];

        foreach ($authors as $data) {
            Author::firstOrCreate(
                ['name' => $data['name']],
                [
                    'slug'        => Str::slug($data['name']),
                    'biography'   => $data['biography'],
                    'nationality' => $data['nationality'],
                    'email'       => null,
                    'website'     => null,
                    'photo_path'  => null,
                ]
            );
        }
    }
}
