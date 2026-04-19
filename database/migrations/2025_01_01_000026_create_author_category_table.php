<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Agregar relación many-to-many entre autores y categorías
     * Permite que un autor esté asociado a múltiples categorías
     */
    public function up(): void
    {
        Schema::create('author_category', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id')->constrained('authors')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->timestamps();
            
            // Evitar duplicados
            $table->unique(['author_id', 'category_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('author_category');
    }
};
