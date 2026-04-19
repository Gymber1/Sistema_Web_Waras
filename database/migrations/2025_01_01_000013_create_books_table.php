<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tabla principal de libros/documentos para la Biblioteca.
     * Soporta múltiples tipos de documentos (Libros, Artículos, Revistas, Tesis).
     */
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->string('slug', 255)->unique();
            $table->text('summary')->nullable();
            $table->string('publication_date', 50)->nullable(); // Fecha de publicación flexible
            $table->enum('document_type', ['Libro', 'Artículo', 'Revista', 'Tesis'])->default('Libro');
            $table->string('isbn', 20)->nullable();
            $table->integer('pages')->nullable();
            $table->string('language', 50)->default('Español');
            $table->text('descriptors')->nullable(); // Palabras clave/descriptores
            $table->string('provider')->nullable(); // Proveído por
            $table->string('cover_image_path')->nullable(); // Portada del libro
            
            // Lógica de fuente única: un libro TIENE un URL externo O un PDF, pero no ambos
            $table->enum('source_type', ['external', 'pdf', 'none'])->default('none');
            $table->text('external_url')->nullable(); // URL externa si source_type = 'external'
            $table->string('pdf_file_path')->nullable(); // Ruta del PDF si source_type = 'pdf'
            
            $table->foreignId('publisher_id')->nullable()->constrained('publishers')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
