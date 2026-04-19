<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tabla para manejar módulos/colecciones (Biblioteca, Fototeca, Musicoteca, etc.)
     * Esta tabla es la clave para la escalabilidad del sistema.
     * Permite agregar nuevos módulos sin reescribir la BD.
     */
    public function up(): void
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique(); // 'Biblioteca', 'Fototeca', 'Musicoteca'
            $table->string('slug', 100)->unique(); // 'biblioteca', 'fototeca', 'musicoteca'
            $table->text('description')->nullable();
            $table->string('base_url')->unique(); // URL base para acceso al módulo
            $table->boolean('is_active')->default(true);
            $table->json('config')->nullable(); // Configuración específica del módulo (JSON)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modules');
    }
};
