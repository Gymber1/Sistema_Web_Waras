<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Http\Request;

trait HasSortableColumns
{
    /**
     * Aplica ordenamiento a una consulta según los parámetros ?sort= y ?dir=.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  \Illuminate\Http\Request  $request
     * @param  array   $allowed   Lista blanca de columnas permitidas (seguridad).
     * @param  string  $default   Columna por defecto si no se pide orden o no es válida.
     * @param  string  $defaultDir  Dirección por defecto ('asc' | 'desc').
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function applySort($query, Request $request, array $allowed, string $default, string $defaultDir = 'asc', array $custom = [])
    {
        $sort = $request->input('sort');
        $dir  = strtolower($request->input('dir', $defaultDir)) === 'desc' ? 'desc' : 'asc';

        // Columnas "virtuales" (ej. relaciones) resueltas por un callback: fn($query, $dir) => $query
        if ($sort && isset($custom[$sort]) && is_callable($custom[$sort])) {
            return $custom[$sort]($query, $dir);
        }

        if ($sort && in_array($sort, $allowed, true)) {
            return $query->orderBy($sort, $dir);
        }

        // Sin orden válido: usar el por defecto
        return $query->orderBy($default, $defaultDir);
    }
}
