<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Convierte las imágenes subidas a WebP y les limita el tamaño.
 *
 * Motivo: las fotos que se suben desde el panel venían en PNG/JPG a resolución
 * completa (hasta 13 MB cada una), lo que hacía muy lenta la galería en celular.
 * WebP pesa entre un 70% y un 90% menos sin pérdida visible.
 *
 * Si algo falla (formato no soportado, GD sin WebP, imagen corrupta) se guarda
 * el archivo original tal cual: nunca se pierde una subida.
 */
class ImageOptimizer
{
    /**
     * Ancho/alto máximo en píxeles.
     * 1920 es Full HD: suficiente para verse nítida a pantalla completa y para
     * hacer zoom razonable en el visor. Subir de ahí solo multiplica el peso.
     */
    public const MAX_WIDTH  = 1920;
    public const MAX_HEIGHT = 1920;

    /**
     * Calidad WebP (0-100). 75 es el punto donde la diferencia visual todavía
     * es imperceptible en fotografía pero el ahorro es notable frente a 82.
     */
    public const QUALITY = 75;

    /** Ancho de la miniatura que usan las galerías (tarjetas de ~300-400px). */
    public const THUMB_WIDTH = 450;

    /** Calidad de la miniatura: al verse pequeña admite más compresión. */
    public const THUMB_QUALITY = 68;

    /** Formatos que sabemos convertir. */
    private const CONVERTIBLE = ['jpg', 'jpeg', 'png', 'webp', 'bmp'];

    /**
     * Guarda una imagen subida, convertida a WebP.
     *
     * @param  string  $folder  Carpeta dentro del disco (ej. 'photos', 'covers')
     * @param  bool    $thumb   Si además genera miniatura en <folder>/thumbs
     * @return string           Ruta relativa guardada (ej. 'photos/abc123.webp')
     */
    public static function store(UploadedFile $file, string $folder, bool $thumb = false): string
    {
        // Sin GD/WebP o formato raro: guardar como siempre
        if (! self::canConvert($file)) {
            return $file->store($folder, 'public');
        }

        $image = self::readImage($file->getRealPath());
        if (! $image) {
            return $file->store($folder, 'public');
        }

        $image = self::resizeToLimit($image);

        $name = Str::random(40) . '.webp';
        $path = $folder . '/' . $name;

        $tmp = tempnam(sys_get_temp_dir(), 'webp');
        $ok  = imagewebp($image, $tmp, self::QUALITY);

        if (! $ok) {
            imagedestroy($image);
            @unlink($tmp);
            return $file->store($folder, 'public');
        }

        Storage::disk('public')->put($path, file_get_contents($tmp));
        @unlink($tmp);

        if ($thumb) {
            self::makeThumb($image, $folder, $name);
        }

        imagedestroy($image);

        return $path;
    }

    /**
     * Convierte un archivo que ya está en el disco público.
     * Devuelve la nueva ruta, o null si no se pudo convertir.
     */
    public static function convertExisting(string $relativePath, bool $thumb = false): ?string
    {
        $disk = Storage::disk('public');
        if (! $disk->exists($relativePath)) {
            return null;
        }

        $ext = strtolower(pathinfo($relativePath, PATHINFO_EXTENSION));
        if (! in_array($ext, self::CONVERTIBLE, true) || ! self::webpSupported()) {
            return null;
        }

        $full  = $disk->path($relativePath);
        $image = self::readImage($full);
        if (! $image) {
            return null;
        }

        $image = self::resizeToLimit($image);

        $folder  = dirname($relativePath);
        $folder  = $folder === '.' ? '' : $folder;
        $name    = pathinfo($relativePath, PATHINFO_FILENAME) . '.webp';
        $newPath = $folder ? $folder . '/' . $name : $name;

        $tmp = tempnam(sys_get_temp_dir(), 'webp');

        // Si GD no puede con esta imagen concreta, se devuelve null y el
        // proceso sigue con las demas en vez de detenerse a medio camino.
        try {
            $ok = @imagewebp($image, $tmp, self::QUALITY);
        } catch (\Throwable $e) {
            $ok = false;
        }

        if (! $ok) {
            imagedestroy($image);
            @unlink($tmp);
            return null;
        }

        $disk->put($newPath, file_get_contents($tmp));
        @unlink($tmp);

        if ($thumb && $folder) {
            self::makeThumb($image, $folder, $name);
        }

        imagedestroy($image);

        return $newPath;
    }

    /**
     * Genera la miniatura de una imagen que ya está en el disco.
     * Útil para archivos convertidos antes de que existieran las miniaturas.
     */
    public static function makeThumbFor(string $relativePath): bool
    {
        $disk = Storage::disk('public');
        if (! $disk->exists($relativePath) || ! self::webpSupported()) {
            return false;
        }

        $image = self::readImage($disk->path($relativePath));
        if (! $image) {
            return false;
        }

        $folder = dirname($relativePath);
        $folder = $folder === '.' ? '' : $folder;
        if (! $folder) {
            imagedestroy($image);
            return false;
        }

        self::makeThumb($image, $folder, basename($relativePath));
        imagedestroy($image);

        return $disk->exists($folder . '/thumbs/' . basename($relativePath));
    }

    /**
     * Borra una imagen y su miniatura.
     *
     * Al reemplazar o eliminar contenido hay que quitar ambas: si solo se borra
     * la original, la miniatura queda ocupando espacio sin que nadie la use.
     */
    public static function delete(?string $relativePath): void
    {
        if (! $relativePath) {
            return;
        }

        $disk = Storage::disk('public');
        $disk->delete($relativePath);

        $thumb = dirname($relativePath) . '/thumbs/' . basename($relativePath);
        if ($disk->exists($thumb)) {
            $disk->delete($thumb);
        }
    }

    /** Genera la miniatura en <folder>/thumbs/<nombre>. */
    private static function makeThumb($image, string $folder, string $name): void
    {
        $w = imagesx($image);
        $h = imagesy($image);

        if ($w <= self::THUMB_WIDTH) {
            return; // ya es pequeña, no hace falta
        }

        $tw = self::THUMB_WIDTH;
        $th = (int) round($h * ($tw / $w));

        $thumb = imagecreatetruecolor($tw, $th);
        self::preserveTransparency($thumb);
        imagecopyresampled($thumb, $image, 0, 0, 0, 0, $tw, $th, $w, $h);

        $tmp = tempnam(sys_get_temp_dir(), 'webpt');
        if (imagewebp($thumb, $tmp, self::THUMB_QUALITY)) {
            Storage::disk('public')->put($folder . '/thumbs/' . $name, file_get_contents($tmp));
        }
        @unlink($tmp);
        imagedestroy($thumb);
    }

    /** Reduce la imagen si excede el máximo, manteniendo la proporción. */
    private static function resizeToLimit($image)
    {
        $w = imagesx($image);
        $h = imagesy($image);

        if ($w <= self::MAX_WIDTH && $h <= self::MAX_HEIGHT) {
            return $image;
        }

        $ratio = min(self::MAX_WIDTH / $w, self::MAX_HEIGHT / $h);
        $nw = (int) round($w * $ratio);
        $nh = (int) round($h * $ratio);

        $resized = imagecreatetruecolor($nw, $nh);
        self::preserveTransparency($resized);
        imagecopyresampled($resized, $image, 0, 0, 0, 0, $nw, $nh, $w, $h);
        imagedestroy($image);

        return $resized;
    }

    /** Mantiene el fondo transparente de los PNG al redimensionar. */
    private static function preserveTransparency($image): void
    {
        imagealphablending($image, false);
        imagesavealpha($image, true);
        $transparent = imagecolorallocatealpha($image, 0, 0, 0, 127);
        imagefill($image, 0, 0, $transparent);
    }

    /** Abre la imagen según su tipo real (no según la extensión). */
    private static function readImage(string $path)
    {
        $info = @getimagesize($path);
        if (! $info) {
            return null;
        }

        $image = match ($info[2]) {
            IMAGETYPE_JPEG => @imagecreatefromjpeg($path),
            IMAGETYPE_PNG  => @imagecreatefrompng($path),
            IMAGETYPE_WEBP => @imagecreatefromwebp($path),
            IMAGETYPE_BMP  => @imagecreatefrombmp($path),
            default        => null,
        };

        if (! $image) {
            return null;
        }

        // WebP no admite imagenes con paleta de colores (PNG de 8 bits y
        // similares): hay que pasarlas a color verdadero o imagewebp() falla
        // con "Palette image not supported by webp".
        if (! imageistruecolor($image)) {
            if (function_exists('imagepalettetotruecolor')) {
                imagepalettetotruecolor($image);
            } else {
                $w = imagesx($image);
                $h = imagesy($image);
                $true = imagecreatetruecolor($w, $h);
                self::preserveTransparency($true);
                imagecopy($true, $image, 0, 0, 0, 0, $w, $h);
                imagedestroy($image);
                $image = $true;
            }
        }

        if ($info[2] === IMAGETYPE_PNG) {
            imagealphablending($image, true);
            imagesavealpha($image, true);
        }

        return $image;
    }

    private static function canConvert(UploadedFile $file): bool
    {
        $ext = strtolower($file->getClientOriginalExtension());
        return self::webpSupported() && in_array($ext, self::CONVERTIBLE, true);
    }

    private static function webpSupported(): bool
    {
        return function_exists('imagewebp') && function_exists('imagecreatetruecolor');
    }
}
