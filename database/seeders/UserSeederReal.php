<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Module;
use Illuminate\Database\Seeder;

class UserSeederReal extends Seeder
{
    /**
     * Crear usuarios REALES (sin datos ficticios).
     * Este seeder contiene solo los datos de usuarios reales que necesita el sistema.
     */
    public function run(): void
    {
        // 1. SUPER ADMINISTRADOR - El fundador del sistema
        $admin = User::create([
            'name' => 'Administrador WARAS',
            'email' => 'admin@waras.local',
            'password' => bcrypt('Admin@2025'),
            'is_admin_global' => true,
            'is_deletable' => false,
        ]);

        // 2. MODERADOR DE BIBLIOTECA (Usuario real)
        $mod_biblioteca = User::create([
            'name' => 'Gerente Biblioteca',
            'email' => 'biblioteca@waras.local',
            'password' => bcrypt('Biblioteca@2025'),
            'is_admin_global' => false,
            'is_deletable' => true,
        ]);

        // Asignar al módulo Biblioteca
        $biblioteca = Module::where('slug', 'biblioteca')->first();
        if ($biblioteca) {
            $mod_biblioteca->modules()->attach($biblioteca->id);
        }

        // 3. MODERADOR DE FOTOTECA (Usuario real)
        $mod_fototeca = User::create([
            'name' => 'Curador Fototeca',
            'email' => 'fototeca@waras.local',
            'password' => bcrypt('Fototeca@2025'),
            'is_admin_global' => false,
            'is_deletable' => true,
        ]);

        // Asignar al módulo Fototeca
        $fototeca = Module::where('slug', 'fototeca')->first();
        if ($fototeca) {
            $mod_fototeca->modules()->attach($fototeca->id);
        }
    }
}
