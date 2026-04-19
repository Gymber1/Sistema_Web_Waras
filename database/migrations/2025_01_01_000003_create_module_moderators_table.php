<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tabla pivote para asignar moderadores a módulos específicos.
     * Un moderador puede gestionar uno o más módulos, y un módulo
     * puede tener uno o más moderadores.
     */
    public function up(): void
    {
        Schema::create('module_moderators', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('module_id')->constrained('modules')->onDelete('cascade');
            $table->timestamps();
            
            // Garantizar que no haya duplicados (un moderador, un módulo)
            $table->unique(['user_id', 'module_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('module_moderators');
    }
};
