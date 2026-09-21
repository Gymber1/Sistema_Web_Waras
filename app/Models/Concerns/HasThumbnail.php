<?php

namespace App\Models\Concerns;

use Illuminate\Support\Facades\Storage;

/**
 * Devuelve la miniatura de una imagen cuando existe.
 *
 * Al optimizar el acervo se generan versiones reducidas en <carpeta>/thumbs/.
 * Las grillas (galerías públicas y tablas del panel) deben usar esas miniaturas:
 * cargar la imagen completa en una tarjeta de 300px hace que la página tarde
 * muchísimo cuando hay decenas de resultados.
 */
trait HasThumbnail
{
    /**
     * URL de la miniatura si está disponible; si no, la de la imagen original.
     */
    public static function thumbUrl(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        $thumb = dirname($path) . '/thumbs/' . basename($path);

        if (Storage::disk('public')->exists($thumb)) {
            return Storage::url($thumb);
        }

        return Storage::url($path);
    }
}
