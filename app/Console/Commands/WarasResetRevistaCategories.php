<?php

namespace App\Console\Commands;

use App\Models\Category;
use Illuminate\Console\Command;

class WarasResetRevistaCategories extends Command
{
    protected $signature = 'waras:reset-revista-categories {--force : Ejecutar sin pedir confirmación}';

    protected $description = 'Deja vacías las categorías de Revistas (type=revista). Útil en el servidor donde ya se crearon categorías de revista que deben empezar limpias. Las categorías de Libros (type=biblioteca) NO se tocan.';

    public function handle(): int
    {
        $count = Category::where('type', 'revista')->count();

        if ($count === 0) {
            $this->info('No hay categorías de Revistas (type=revista). Nada que hacer.');
            return self::SUCCESS;
        }

        $this->warn("Se eliminarán {$count} categoría(s) de Revistas (type=revista).");
        $this->line('Las categorías de Libros (type=biblioteca) NO se verán afectadas.');

        if (!$this->option('force') && !$this->confirm('¿Continuar?')) {
            $this->info('Cancelado.');
            return self::SUCCESS;
        }

        // Eliminar hijos primero para respetar posibles llaves foráneas del árbol.
        Category::where('type', 'revista')->whereNotNull('parent_id')->delete();
        Category::where('type', 'revista')->delete();

        $this->info("Listo. Categorías de Revistas vaciadas ({$count} eliminadas).");
        return self::SUCCESS;
    }
}
