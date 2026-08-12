<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Agrega columna 'order' al pivote book_descriptor para poder ordenar
     * los descriptores de cada libro tal como los deja el administrador.
     */
    public function up(): void
    {
        Schema::table('book_descriptor', function (Blueprint $table) {
            $table->unsignedInteger('order')->default(0)->after('descriptor_id');
        });
    }

    public function down(): void
    {
        Schema::table('book_descriptor', function (Blueprint $table) {
            $table->dropColumn('order');
        });
    }
};
