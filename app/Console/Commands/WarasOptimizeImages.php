<?php

namespace App\Console\Commands;

use App\Services\ImageOptimizer;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * Convierte a WebP las imágenes que ya estaban subidas y actualiza la ruta
 * guardada en la base de datos.
 *
 * Por defecto borra el original una vez convertido, para no duplicar peso.
 * Con --keep se mueven a storage/app/public/_originales en lugar de borrarse.
 */
class WarasOptimizeImages extends Command
{
    protected $signature = 'waras:optimize-images
                            {--dry-run : Solo muestra lo que haría, sin tocar nada}
                            {--keep    : Conserva los originales en _originales (por defecto se borran)}
                            {--only=   : Limitar a una carpeta (ej. photos)}';

    protected $description = 'Convierte a WebP las imágenes ya subidas y actualiza la base de datos';

    /**
     * Cada entrada: tabla => [columna => carpeta]
     * La carpeta indica si además se genera miniatura.
     */
    private const MAP = [
        'photos'        => ['full_image_path'   => 'photos',
                            'thumbnail_path'    => 'photos'],
        'books'         => ['cover_image_path'  => 'covers'],
        'photographers' => ['photo_path'        => 'photographers'],
        'donors'        => ['photo_path'        => 'donors'],
        'authors'       => ['photo_path'        => 'authors'],
        'publishers'    => ['logo_path'         => 'publishers'],
        'specials'      => ['cover_image_path'  => 'specials'],
    ];

    /** Carpetas cuyas imágenes se muestran en grillas: merecen miniatura. */
    private const THUMB_FOLDERS = ['photos', 'covers', 'collections'];

    public function handle(): int
    {
        if (! function_exists('imagewebp')) {
            $this->error('Esta instalación de PHP no tiene soporte WebP (GD). No se puede continuar.');
            return self::FAILURE;
        }

        $dry   = (bool) $this->option('dry-run');
        $keep  = (bool) $this->option('keep');
        $only  = $this->option('only');

        if ($dry) {
            $this->warn('MODO PRUEBA: no se modificará ningún archivo ni la base de datos.');
        }

        $disk = Storage::disk('public');

        $totalBefore = 0;
        $totalAfter  = 0;
        $converted   = 0;
        $skipped     = 0;
        $failed      = 0;

        // Un mismo archivo puede estar referenciado por varias columnas
        // (p. ej. photos.full_image_path y photos.thumbnail_path apuntan al mismo
        // fichero). Guardamos original => convertido para reutilizar la conversión
        // y no borrar un archivo que otra columna todavía necesita.
        $alreadyConverted = [];

        foreach (self::MAP as $table => $columns) {
            if (! DB::getSchemaBuilder()->hasTable($table)) {
                continue;
            }

            foreach ($columns as $column => $folder) {
                if ($only && $only !== $folder) {
                    continue;
                }
                if (! DB::getSchemaBuilder()->hasColumn($table, $column)) {
                    continue;
                }

                $rows = DB::table($table)
                    ->select('id', $column)
                    ->whereNotNull($column)
                    ->where($column, '!=', '')
                    ->get();

                if ($rows->isEmpty()) {
                    continue;
                }

                $this->line("\n<fg=cyan>{$table}.{$column}</> ({$rows->count()} registros)");

                foreach ($rows as $row) {
                    $path = $row->$column;

                    if (str_ends_with(strtolower($path), '.webp')) {
                        $skipped++;
                        continue;
                    }
                    if (! $disk->exists($path)) {
                        $this->line("  <fg=yellow>falta</> {$path}");
                        $skipped++;
                        continue;
                    }

                    $sizeBefore = $disk->size($path);

                    if ($dry) {
                        $this->line(sprintf('  %s  (%s)', $path, $this->human($sizeBefore)));
                        $totalBefore += $sizeBefore;
                        $converted++;
                        continue;
                    }

                    // ¿Ya se convirtió este mismo archivo desde otra columna?
                    if (isset($alreadyConverted[$path])) {
                        $newPath = $alreadyConverted[$path];
                        DB::table($table)->where('id', $row->id)->update([$column => $newPath]);
                        $this->line("  <fg=green>ok</> (reutiliza {$newPath})");
                        $converted++;
                        continue;
                    }

                    $withThumb = in_array($folder, self::THUMB_FOLDERS, true);
                    $newPath   = ImageOptimizer::convertExisting($path, $withThumb);

                    if (! $newPath) {
                        $this->line("  <fg=red>falló</> {$path}");
                        $failed++;
                        continue;
                    }

                    $sizeAfter = $disk->size($newPath);
                    $alreadyConverted[$path] = $newPath;

                    DB::table($table)->where('id', $row->id)->update([$column => $newPath]);

                    // Actualizar TODAS las demás columnas que apunten al mismo archivo,
                    // para que ninguna quede señalando un original ya borrado.
                    foreach (self::MAP as $otherTable => $otherCols) {
                        foreach (array_keys($otherCols) as $otherCol) {
                            if ($otherTable === $table && $otherCol === $column) continue;
                            if (! DB::getSchemaBuilder()->hasTable($otherTable)) continue;
                            if (! DB::getSchemaBuilder()->hasColumn($otherTable, $otherCol)) continue;
                            DB::table($otherTable)->where($otherCol, $path)->update([$otherCol => $newPath]);
                        }
                    }

                    // El original ya no se usa: se borra (o se respalda con --keep).
                    // Solo se toca cuando la conversión produjo un archivo distinto
                    // y ese archivo nuevo existe de verdad, para no perder nada.
                    if ($newPath !== $path && $disk->exists($newPath)) {
                        if ($keep) {
                            $disk->move($path, '_originales/' . $path);
                        } else {
                            $disk->delete($path);
                        }
                    }

                    $totalBefore += $sizeBefore;
                    $totalAfter  += $sizeAfter;
                    $converted++;

                    $pct = $sizeBefore > 0 ? round(100 - ($sizeAfter / $sizeBefore * 100)) : 0;
                    $this->line(sprintf(
                        '  <fg=green>ok</> %s → %s  (-%d%%)',
                        $this->human($sizeBefore),
                        $this->human($sizeAfter),
                        $pct
                    ));
                }
            }
        }

        $this->newLine();

        if ($dry) {
            $this->info("Se convertirían {$converted} imágenes ({$this->human($totalBefore)}).");
            $this->line('Ejecuta el comando sin --dry-run para aplicarlo.');
            return self::SUCCESS;
        }

        $saved = $totalBefore - $totalAfter;
        $pct   = $totalBefore > 0 ? round($saved / $totalBefore * 100) : 0;

        $this->info("Convertidas: {$converted}   Omitidas: {$skipped}   Fallidas: {$failed}");
        $this->info(sprintf(
            'Antes: %s   Después: %s   Ahorro: %s (%d%%)',
            $this->human($totalBefore),
            $this->human($totalAfter),
            $this->human($saved),
            $pct
        ));

        if ($keep && $converted > 0) {
            $this->newLine();
            $this->comment('Los originales quedaron en storage/app/public/_originales');
            $this->comment('Cuando compruebes que todo se ve bien, puedes borrar esa carpeta.');
        }

        return self::SUCCESS;
    }

    private function human(int $bytes): string
    {
        if ($bytes >= 1048576) return round($bytes / 1048576, 1) . ' MB';
        if ($bytes >= 1024)    return round($bytes / 1024) . ' KB';
        return $bytes . ' B';
    }
}
