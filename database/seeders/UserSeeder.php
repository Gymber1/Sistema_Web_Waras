<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Module;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Crear:
     * 1. Super Administrador (ID 1, inborrable, acceso global)
     * 2. Moderador de Biblioteca
     * 3. Moderador de Fototeca
     */
    public function run(): void
    {
        // 1. SUPER ADMINISTRADOR - el fundador del sistema
        // Nunca puede ser eliminado (is_deletable = false)
        $admin = User::create([
            'name' => 'Administrador Sistema',
            'email' => 'admin@waras.local',
            'password' => bcrypt('Admin@2025'),
            'is_admin_global' => true,  // Acceso a TODOS los módulos
            'is_deletable' => false,    // Protegido: nunca puede ser eliminado
        ]);

        // 2. MODERADOR DE BIBLIOTECA
        $moderador_biblioteca = User::create([
            'name' => 'Moderador Biblioteca',
            'email' => 'biblioteca@waras.local',
            'password' => bcrypt('Biblioteca@2025'),
            'is_admin_global' => false,
            'is_deletable' => true,
        ]);

        // Asignar al módulo Biblioteca mediante tabla pivot
        $biblioteca = Module::where('slug', 'biblioteca')->first();
        if ($biblioteca) {
            $moderador_biblioteca->modules()->attach($biblioteca->id);
        }

        // 3. MODERADOR DE FOTOTECA
        $moderador_fototeca = User::create([
            'name' => 'Moderador Fototeca',
            'email' => 'fototeca@waras.local',
            'password' => bcrypt('Fototeca@2025'),
            'is_admin_global' => false,
            'is_deletable' => true,
        ]);

        // Asignar al módulo Fototeca mediante tabla pivot
        $fototeca = Module::where('slug', 'fototeca')->first();
        if ($fototeca) {
            $moderador_fototeca->modules()->attach($fototeca->id);
        }
    }
}
