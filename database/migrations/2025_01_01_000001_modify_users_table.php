<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Modifica la tabla users para agregar campos de roles y protección del admin del sistema.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Flag para administrador global (acceso a todos los módulos)
            $table->boolean('is_admin_global')->default(false)->after('email_verified_at');
            
            // Flag de protección: el admin del sistema (ID 1) nunca puede ser eliminado
            $table->boolean('is_deletable')->default(true)->after('is_admin_global');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['is_admin_global', 'is_deletable']);
        });
    }
};
