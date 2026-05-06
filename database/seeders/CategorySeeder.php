<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // ==========================================
        // BIBLIOTECA (2 niveles: categoría → subcategoría)
        // ==========================================
        $bibliotecaData = [
            'Generalidades'                     => ['Bibliotecas', 'Libros', 'Lectura', 'Organizaciones y Museología', 'Periodismo', 'Sistemas'],
            'Filosofía Y Psicología'             => [],
            'Religión'                           => [],
            'Ciencias Sociales'                  => ['Economía', 'Derecho', 'Administración Pública', 'Educación', 'Transporte', 'Costumbres Y Folklore', 'Sociología y Antropología'],
            'Lenguas'                            => ['Quechua Ancashino'],
            'Ciencias Naturales Y Matemáticas'   => ['Biología (Ecología)', 'Plantas', 'Animales', 'Física'],
            'Ciencias Aplicadas (Tecnología)'    => ['Ciencias Médicas', 'Ingeniería', 'Agricultura', 'Manufacturas', 'Construcciones'],
            'Arte'                               => [],
            'Literatura'                         => ['Poesía Ancashina', 'Narrativa Ancashina', 'Mitos y Leyendas', 'Antologías (varios géneros)', 'Ensayos Ancashinos'],
            'Historia Y Geografía'               => ['Historia Ancashina', 'Geografía Ancashina', 'Biografías Ancashinas', 'Geografía y Viajes'],
        ];

        foreach ($bibliotecaData as $parentName => $children) {
            $parent = Category::firstOrCreate(
                ['name' => $parentName, 'type' => 'biblioteca', 'parent_id' => null],
                ['slug' => $this->uniqueSlug($parentName)],
            );
            foreach ($children as $childName) {
                Category::firstOrCreate(
                    ['name' => $childName, 'type' => 'biblioteca', 'parent_id' => $parent->id],
                    ['slug' => $this->uniqueSlug($childName)],
                );
            }
        }

        // ==========================================
        // FOTOTECA — estructura exacta según tru.txt
        // Niveles:
        //   Categoría (nivel 1)
        //   └─ Subcategoría (nivel 2)
        //      └─ 1er Nivel (nivel 3)
        //         └─ 2do Nivel (nivel 4)
        //            └─ 3er Nivel (nivel 5)
        //
        // Los 2do Nivel de "Por Ciudades" tienen 3er nivel:
        //   (Antes del Terremoto / Terremoto / Después del Terremoto / Siglo XXI)
        // ==========================================

        // Períodos de tiempo usados como 3er Nivel
        $periodos = ['Antes del Terremoto', 'Terremoto', 'Después del Terremoto', 'Siglo XXI'];

        // ── CATEGORÍA: Por Provincias ─────────────────────────────────
        $catProvincias = $this->cat('Por Provincias', null);

        // Subcategoría: Por Distritos
        $subDistritos = $this->cat('Por Distritos', $catProvincias->id);

        // Subcategoría: Por Ciudades
        $subCiudades = $this->cat('Por Ciudades', $catProvincias->id);

        // 1er Nivel bajo "Por Ciudades"
        foreach ([
            'Panorámica',
            'Plaza de Armas y Catedral',
            'Puentes',
            'Calles',
            'Casas y Edificios',
        ] as $primerNivelNombre) {
            $pn = $this->cat($primerNivelNombre, $subCiudades->id);
            // 2do Nivel: los 4 períodos directamente
            foreach ($periodos as $periodo) {
                $dn = $this->cat($periodo, $pn->id);
                // 3er Nivel: tipos de vistas dentro de cada período
                foreach ($this->terNivelVistas($primerNivelNombre) as $terNivel) {
                    $this->cat($terNivel, $dn->id);
                }
            }
        }

        // 1er Nivel: Por Barrios (con 2do Nivel = barrios, y 3er Nivel = períodos)
        $pnBarrios = $this->cat('Por Barrios', $subCiudades->id);
        $barrios = ['Belén', 'San Francisco', 'La Soledad', 'Huarupampa', 'Centenario', 'Nicrupampa'];
        foreach ($barrios as $barrio) {
            $dn = $this->cat($barrio, $pnBarrios->id);
            foreach ($periodos as $periodo) {
                $this->cat($periodo, $dn->id);
            }
        }

        // 1er Nivel: Sociedad y Cultura (con 2do Nivel = instituciones, y 3er Nivel = períodos)
        $pnSociedad = $this->cat('Sociedad y Cultura', $subCiudades->id);
        $instituciones = [
            'Instituciones Sociales',
            'Instituciones Culturales',
            'Instituciones Educativas',
            'Deportes',
            'Familias',
        ];
        foreach ($instituciones as $inst) {
            $dn = $this->cat($inst, $pnSociedad->id);
            foreach ($periodos as $periodo) {
                $this->cat($periodo, $dn->id);
            }
        }

        // ── CATEGORÍA: Especiales ─────────────────────────────────────
        $catEspeciales = $this->cat('Especiales', null);

        // Subcategoría: Desastres en Ancash
        $subDesastres = $this->cat('Desastres en Ancash', $catEspeciales->id);
        foreach ([
            'Aluvión de Huaraz de 1941',
            'Aluvión de Chavín de 1945',
            'Aluvión de Ranrahirca de 1962',
            'Terremoto del 31 de mayo de 1970',
            'Aluvión del 31 de mayo de 1970',
        ] as $desastre) {
            $pn = $this->cat($desastre, $subDesastres->id);
            // 3er Nivel: tipos de documentación
            foreach (['Fotografías', 'Testimonios', 'Registro Oficial', 'Prensa'] as $terNivel) {
                $this->cat($terNivel, $pn->id);
            }
        }

        // Subcategoría: Tradiciones y Costumbres de Huaraz
        $subTradiciones = $this->cat('Tradiciones y Costumbres de Huaraz', $catEspeciales->id);
        foreach ([
            'Fiesta del Señor de Mayo',
            'Semana Santa Huaracina',
            'Fiesta de Cruces y Carnavales',
        ] as $tradicion) {
            $pn = $this->cat($tradicion, $subTradiciones->id);
            // 3er Nivel: aspectos de cada tradición
            foreach (['Procesión', 'Danzas', 'Música', 'Gastronomía', 'Indumentaria'] as $aspecto) {
                $this->cat($aspecto, $pn->id);
            }
        }

        // Subcategoría: Patrimonio Arqueológico Ancashino
        $subPatrimonio = $this->cat('Patrimonio Arqueológico Ancashino', $catEspeciales->id);
        foreach ([
            'Sechín',
            'Chavín',
            'Wicahuain',
            'Yaino',
            'Tumshukaiko',
        ] as $sitio) {
            $pn = $this->cat($sitio, $subPatrimonio->id);
            // 3er Nivel: tipos de elementos arqueológicos
            foreach (['Arquitectura', 'Relieves y Esculturas', 'Cerámica', 'Vista General', 'Excavaciones'] as $elem) {
                $this->cat($elem, $pn->id);
            }
        }

        // Subcategoría: Parque Nacional Huascarán
        $subHuascaran = $this->cat('Parque Nacional Huascarán', $catEspeciales->id);

        // 1er Nivel: Nevados y Lagunas
        $pnNevados = $this->cat('Nevados y Lagunas', $subHuascaran->id);
        // 2do Nivel: cada nevado/laguna + 3er Nivel: tipos de vistas
        foreach ([
            'Huascarán', 'Alpamayo', 'Artesonraju', 'Cayesh',
            'Chopicalqui', 'Copa', 'Hualcán',
            'Laguna Parón', 'Laguna Llanganuco', 'Laguna Churup', 'Laguna Palcacocha',
        ] as $cumbre) {
            $dn = $this->cat($cumbre, $pnNevados->id);
            foreach (['Vista Panorámica', 'Amanecer y Atardecer', 'Expedición', 'Flora y Fauna'] as $vista) {
                $this->cat($vista, $dn->id);
            }
        }

        // 1er Nivel: Circuitos
        $pnCircuitos = $this->cat('Circuitos', $subHuascaran->id);
        foreach ([
            'Santa Cruz Trek', 'Laguna 69', 'Base Camp Huascarán',
            'Huayhuash Circuit', 'Churup',
        ] as $circuito) {
            $dn = $this->cat($circuito, $pnCircuitos->id);
            foreach (['Inicio de Ruta', 'Campamento', 'Cumbre', 'Paisaje'] as $etapa) {
                $this->cat($etapa, $dn->id);
            }
        }
    }

    /**
     * Retorna los 3er Nivel apropiados según el tipo de vista de ciudad.
     */
    private function terNivelVistas(string $primerNivel): array
    {
        return match ($primerNivel) {
            'Panorámica'              => ['Vista desde el Norte', 'Vista desde el Sur', 'Vista desde el Cerro', 'Aerial / Drone'],
            'Plaza de Armas y Catedral' => ['Fachada Principal', 'Interior', 'Eventos y Ceremonias', 'Entorno'],
            'Puentes'                 => ['Puente Bedoya', 'Puente Quilcay', 'Puente Raimondi', 'Otros Puentes'],
            'Calles'                  => ['Calle José de Sucre', 'Calle Luzuriaga', 'Calle Bolívar', 'Mercado Central', 'Otras Calles'],
            'Casas y Edificios'       => ['Viviendas Coloniales', 'Edificios Públicos', 'Mercados', 'Hoteles y Hospedajes'],
            default                   => ['General'],
        };
    }

    private function cat(string $name, ?int $parentId): Category
    {
        return Category::firstOrCreate(
            ['name' => $name, 'type' => 'fototeca', 'parent_id' => $parentId],
            ['slug' => $this->uniqueSlug($name)],
        );
    }

    private function uniqueSlug(string $name): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $i    = 2;
        while (Category::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $i++;
        }
        return $slug;
    }

    // Método de compatibilidad con migraciones anteriores (ya no se usa)
    private function createFototecaCategories(array $categories, ?int $parentId): void {}
}
