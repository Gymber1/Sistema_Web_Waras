<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = ['key', 'value'];

    public static function get(string $key, ?string $default = null): ?string
    {
        return static::where('key', $key)->value('value') ?? $default;
    }

    public static function set(string $key, ?string $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
    }

    /**
     * Datos editables de la sección "Nuestra Organización" del portal.
     * Devuelve lo guardado en organizacion_data o la estructura por defecto.
     */
    public static function organizacion(): array
    {
        $raw = static::get('organizacion_data');
        $saved = $raw ? json_decode($raw, true) : [];
        // Merge superficial: las claves guardadas (incluidas listas completas) reemplazan al default.
        return array_merge(static::defaultOrganizacion(), is_array($saved) ? $saved : []);
    }

    public static function defaultOrganizacion(): array
    {
        return [
            'hero_title'    => 'Nuestra Organización',
            'hero_subtitle' => 'Conoce la misión, visión y los valores que impulsan la preservación del patrimonio regional.',

            'quienes_eyebrow' => 'Quiénes Somos',
            'quienes_title'   => 'Asociación Waras:',
            'quienes_title_em'=> 'Ciencia y Cultura',
            'quienes_p1'      => 'La <strong>Asociación Waras: Ciencia y Cultura</strong> nació ante el vacío estructural e histórico del Estado en la protección de la identidad cultural.',
            'quienes_p2'      => 'Un grupo de ciudadanos conscientes de que la protección del Medio Ambiente, la Educación, la Cultura y la Investigación son el germen para un sólido Desarrollo Económico y Social decidió aportar para viabilizar el progreso sostenido de Áncash.',
            'quienes_p3'      => 'Áncash es una región privilegiada, con una profunda tradición cultural que subsiste a través del tiempo y una diversidad de recursos naturales únicos. Este portal digital es uno de los espacios que construimos para sistematizar, preservar y difundir el conocimiento.',
            'quienes_img'     => '/Fundadores.jpg',
            'quienes_img_label' => 'Fundadores de WARAS',

            'finalidad_title' => 'Nuestra Finalidad',
            'finalidad_text'  => 'Promover estudios, investigaciones, capacitaciones, propuestas y espacios que aporten al desarrollo económico, social, ambiental, cultural, educacional, científico, tecnológico, y ciudadanía en el departamento de Áncash para la mejora de la calidad de vida de sus ciudadanos.',
            'finalidad_img'   => '/Nuestra_Finalidad.png',

            'objetivo_title' => 'Objetivo General',
            'objetivo_img'   => '/Objetivo_General.png',
            'objetivo_items' => [
                'Contribuir al Desarrollo Económico y Social del Departamento de Ancash.',
                'Preservar y Difundir la Cultura Ancashina al mundo a través de plataformas digitales.',
            ],

            'lineas_title'    => 'Líneas de Trabajo y Alcance',
            'lineas_subtitle' => 'Estrategias específicas orientadas a la investigación, desarrollo y preservación del acervo ancashino.',
            'objetivos_label' => 'Objetivos Específicos',
            'objetivos_items' => [
                'Promover e impulsar las ciencias, arte, identidad, ciudadanía y cultura.',
                'Promover la investigación y capacitación educativa, artística y ambiental.',
                'Promover y ejecutar proyectos y programas que desarrollen capacidades científicas.',
                'Lograr el desarrollo de nuestros fines en alianza y convenios con instituciones.',
                'Desarrollar un Sistema y Portal de Información de alcance regional.',
            ],
            'beneficiarios_label' => 'Nuestros Beneficiarios',
            'beneficiarios_items' => [
                'Estudiantes de primaria y secundaria',
                'Estudiantes de nivel superior',
                'Docentes de nivel básico y superior',
                'Autoridades y partidos políticos',
                'Empresarios e inversores regionales',
                'Turistas nacionales e internacionales',
                'Población con interés en ciencia',
                'Investigadores culturales',
            ],

            'premio_title'    => 'Premio Nacional',
            'premio_eyebrow'  => 'Reconocimiento',
            'premio_text'     => 'Proyecto ganador del Ministerio de Cultura para recopilar y difundir el Patrimonio Documental Ancashino.',
            'premio_video'    => 'https://www.youtube.com/embed/DPZWSG2LZ_8?rel=0&modestbranding=1',
            'premio_rec_label'=> 'Beneficiario de las Líneas de Apoyo Económico para el Sector Cultura',
            'premio_ministerio' => 'Ministerio de Cultura',
            'director_label'  => 'Director del Proyecto',
            'director_name'   => 'Giber García Álamo',
            'director_bio'    => 'Promotor inicial de la recopilación histórica. Asumió la dirección para rescatar, catalogar y promover la Identidad Ancashina a través de esta plataforma digital.',
            'director_img'    => '/giber.png',
        ];
    }
}
