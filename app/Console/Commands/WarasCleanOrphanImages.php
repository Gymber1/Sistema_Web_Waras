<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

/**
 * Elimina imágenes que están en el disco pero que ya no usa ningún registro.
 *
 * Se acumulan al reemplazar una portada/foto por otra: el archivo viejo se queda
 * ocupando espacio aunque nadie lo muestre. También quedan los PNG/JPG originales
 * después de convertir el acervo a WebP.
 *
 * Para decidir qué está en uso se revisan TODAS las columnas de la base de datos
 * cuyo nombre sugiera una ruta de archivo, de modo que no se borre nada que
 * alguna parte del sistema siga mostrando.
 */
class WarasCleanOrphanImages extends Command
{
    protected $signature = 'waras:clean-orphan-images
                            {--dry-run : Solo lista lo que borraría, sin borrar nada}
                            {--force   : Borra sin pedir confirmación}';

    protected $description = 'Borra imágenes del disco que ya no están referenciadas en la base de datos';

    /** Carpetas que nunca se tocan (assets fijos del sitio). */
    private const PROTECTED_DIRS = ['logos', 'floating', 'backgrounds', 'contact', '_originales'];

    public function handle(): int
    {
        $dry   = (bool) $this->option('dry-run');
        $disk  = Storage::disk('public');

        $this->info('Buscando rutas referenciadas en la base de datos...');
        $used = $this->collectUsedPaths();
        $this->line('  rutas en uso: ' . count($used));

        $orphans = [];
        $bytes   = 0;

        foreach ($disk->allFiles() as $file) {
            if (! preg_match('/\.(png|jpe?g|bmp|webp)$/i', $file)) {
                continue;
            }
            // No tocar carpetas protegidas
            $topDir = strtok($file, '/');
            if (in_array($topDir, self::PROTECTED_DIRS, true)) {
                continue;
            }
            // Las miniaturas generadas dependen de su imagen principal
            if (str_contains($file, '/thumbs/')) {
                continue;
            }
            if (isset($used[$file])) {
                continue;
            }

            $orphans[] = $file;
            $bytes    += $disk->size($file);
        }

        if (empty($orphans)) {
            $this->info('No hay imágenes huérfanas. Nada que limpiar.');
            return self::SUCCESS;
        }

        $this->newLine();
        $this->warn(sprintf('%d imágenes sin usar  (%s)', count($orphans), $this->human($bytes)));

        foreach (array_slice($orphans, 0, 15) as $o) {
            $this->line('  ' . $o . '  (' . $this->human($disk->size($o)) . ')');
        }
        if (count($orphans) > 15) {
            $this->line('  ... y ' . (count($orphans) - 15) . ' más');
        }

        if ($dry) {
            $this->newLine();
            $this->info('MODO PRUEBA: no se borró nada.');
            $this->line('Ejecuta sin --dry-run para liberar ' . $this->human($bytes) . '.');
            return self::SUCCESS;
        }

        if (! $this->option('force') && ! $this->confirm('¿Borrar estas imágenes definitivamente?', false)) {
            $this->line('Cancelado.');
            return self::SUCCESS;
        }

        $deleted = 0;
        foreach ($orphans as $o) {
            if ($disk->delete($o)) {
                $deleted++;
            }
        }

        $this->newLine();
        $this->info("Borradas {$deleted} imágenes. Liberados " . $this->human($bytes) . '.');

        return self::SUCCESS;
    }

    /**
     * Recorre todas las tablas y recoge los valores de columnas que parecen rutas.
     */
    private function collectUsedPaths(): array
    {
        $used = [];

        foreach (Schema::getTableListing() as $table) {
            $table = str_contains($table, '.') ? substr($table, strrpos($table, '.') + 1) : $table;

            try {
                $columns = Schema::getColumnListing($table);
            } catch (\Throwable $e) {
                continue;
            }

            foreach ($columns as $column) {
                if (! preg_match('/path|image|photo|logo|icon|cover|bg|file/i', $column)) {
                    continue;
                }

                try {
                    $values = DB::table($table)
                        ->whereNotNull($column)
                        ->where($column, '!=', '')
                        ->pluck($column);
                } catch (\Throwable $e) {
                    continue;
                }

                foreach ($values as $value) {
                    if (! is_string($value) || $value === '') {
                        continue;
                    }
                    $clean = ltrim(str_replace('\\', '/', $value), '/');
                    $clean = preg_replace('#^storage/#', '', $clean);
                    $used[$clean] = true;
                }
            }
        }

        return $used;
    }

    private function human(int $bytes): string
    {
        if ($bytes >= 1048576) return round($bytes / 1048576, 1) . ' MB';
        if ($bytes >= 1024)    return round($bytes / 1024) . ' KB';
        return $bytes . ' B';
    }
}
