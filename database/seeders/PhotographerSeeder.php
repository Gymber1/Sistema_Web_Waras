<?php

namespace Database\Seeders;

use App\Models\Photographer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PhotographerSeeder extends Seeder
{
    public function run(): void
    {
        $photographers = [
            [
                'full_name'        => 'Archivo Fotográfico Regional',
                'birth_place'      => 'Huaraz, Áncash',
                'birth_date'       => null,
                'death_date'       => null,
                'biography'        => 'Archivo institucional que recopila el patrimonio fotográfico histórico de la región Áncash, con especial énfasis en el período previo y posterior al terremoto del 31 de mayo de 1970.',
                'studies_critique' => 'Institución de referencia para la documentación visual del patrimonio ancashino.',
            ],
            [
                'full_name'        => 'Carlos Zegarra Huamán',
                'birth_place'      => 'Huaraz, Áncash',
                'birth_date'       => '1940-03-15',
                'death_date'       => null,
                'biography'        => 'Fotógrafo huaracino que documentó de forma sistemática el proceso de reconstrucción de Huaraz tras el terremoto de 1970. Su archivo personal conserva más de dos mil negativos de ese período.',
                'studies_critique' => 'Pionero en la fotografía documental ancashina. Su trabajo es referencia obligada para el estudio visual de la reconstrucción post-sísmica.',
            ],
            [
                'full_name'        => 'Martín Chambi Lanza',
                'birth_place'      => 'Caraz, Áncash',
                'birth_date'       => '1955-07-08',
                'death_date'       => null,
                'biography'        => 'Fotógrafo natural de Caraz especializado en fotografía de montaña y paisaje andino. Ha documentado expediciones a los principales nevados de la Cordillera Blanca durante más de cuatro décadas.',
                'studies_critique' => 'Reconocido internacionalmente por su trabajo en fotografía de alta montaña y patrimonio natural del Parque Nacional Huascarán.',
            ],
            [
                'full_name'        => 'Edmundo Puma Gonzáles',
                'birth_place'      => 'Huaraz, Áncash',
                'birth_date'       => '1962-11-20',
                'death_date'       => null,
                'biography'        => 'Documentalista visual con enfoque en la cultura y tradiciones del Callejón de Huaylas. Ha registrado décadas de festividades, danzas y costumbres de la región.',
                'studies_critique' => 'Su archivo documenta de forma sistemática las transformaciones urbanas y culturales de Huaraz en el Siglo XXI.',
            ],
            [
                'full_name'        => 'Rosendo Flores Quispe',
                'birth_place'      => 'Independencia, Áncash',
                'birth_date'       => '1958-04-12',
                'death_date'       => null,
                'biography'        => 'Fotógrafo de festividades y tradiciones religiosas de la provincia de Huaraz. Ha documentado ininterrumpidamente la Semana Santa Huaracina y la Fiesta del Señor de Mayo por más de treinta años.',
                'studies_critique' => 'Referente en la documentación fotográfica de la religiosidad popular ancashina.',
            ],
            [
                'full_name'        => 'Prof. Carlos Mendoza Silva',
                'birth_place'      => 'Chavín de Huántar, Áncash',
                'birth_date'       => '1950-09-03',
                'death_date'       => null,
                'biography'        => 'Docente universitario y fotógrafo arqueológico. Ha colaborado con misiones científicas en Chavín de Huántar, Sechín y otros sitios arqueológicos ancashinos durante veinticinco años.',
                'studies_critique' => 'Su trabajo fotográfico es complemento visual de numerosas publicaciones académicas sobre arqueología ancashina.',
            ],
            [
                'full_name'        => 'María Luisa Tarazona Espinoza',
                'birth_place'      => 'Yungay, Áncash',
                'birth_date'       => '1965-02-14',
                'death_date'       => null,
                'biography'        => 'Fotógrafa nacida en Yungay que dedica su obra a preservar la memoria del aluvión de 1970. Sus imágenes del Camposanto de Yungay son reconocidas a nivel nacional.',
                'studies_critique' => 'Memoria visual imprescindible del mayor desastre natural ocurrido en el Perú.',
            ],
            [
                'full_name'        => 'Julio César Maguiña Ruiz',
                'birth_place'      => 'Carhuaz, Áncash',
                'birth_date'       => '1970-06-31',
                'death_date'       => null,
                'biography'        => 'Fotógrafo documental contemporáneo centrado en la vida cotidiana de los pueblos del Callejón de Conchucos. Su proyecto "Conchucos Vivo" reúne más de tres mil imágenes.',
                'studies_critique' => 'Representante de la nueva generación de fotógrafos documentales ancashinos.',
            ],
        ];

        foreach ($photographers as $data) {
            Photographer::firstOrCreate(
                ['full_name' => $data['full_name']],
                [
                    'slug'             => Str::slug($data['full_name']),
                    'birth_place'      => $data['birth_place'] ?? null,
                    'birth_date'       => $data['birth_date'] ?? null,
                    'death_date'       => $data['death_date'] ?? null,
                    'biography'        => $data['biography'] ?? null,
                    'studies_critique' => $data['studies_critique'] ?? null,
                    'photo_path'       => null,
                ]
            );
        }
    }
}
