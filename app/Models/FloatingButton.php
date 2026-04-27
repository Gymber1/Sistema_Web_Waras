<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FloatingButton extends Model
{
    protected $fillable = ['slug', 'nombre', 'descripcion', 'imagen', 'logo', 'glow_color', 'link', 'is_default', 'orden'];

    // key => [rgba normal, rgba hover, hex para popover header]
    public static array $GLOW_OPTIONS = [
        'morado'   => ['rgba(116,35,101,0.8)',  'rgba(116,35,101,1)',  '#742364'],
        'verde'    => ['rgba(37,211,102,0.8)',   'rgba(37,211,102,1)',  '#128C7E'],
        'indigo'   => ['rgba(99,102,241,0.8)',   'rgba(99,102,241,1)',  '#4f46e5'],
        'azul'     => ['rgba(59,130,246,0.8)',   'rgba(59,130,246,1)',  '#2563eb'],
        'rojo'     => ['rgba(239,68,68,0.8)',    'rgba(239,68,68,1)',   '#dc2626'],
        'naranja'  => ['rgba(249,115,22,0.8)',   'rgba(249,115,22,1)',  '#ea580c'],
        'amarillo' => ['rgba(234,179,8,0.8)',    'rgba(234,179,8,1)',   '#ca8a04'],
        'rosa'     => ['rgba(236,72,153,0.8)',   'rgba(236,72,153,1)', '#db2777'],
        'cian'     => ['rgba(6,182,212,0.8)',    'rgba(6,182,212,1)',   '#0891b2'],
        'blanco'   => ['rgba(255,255,255,0.6)',  'rgba(255,255,255,0.9)', '#64748b'],
    ];

    protected $casts = ['is_default' => 'boolean'];
}
