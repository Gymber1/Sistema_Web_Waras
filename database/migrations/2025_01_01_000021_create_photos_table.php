<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('photos', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->string('slug', 255)->unique();
            $table->text('description')->nullable();   // Descripción: lugar / persona / acontecimiento
            $table->unsignedSmallInteger('year')->nullable(); // Año de la fotografía
            $table->string('provider')->nullable();    // Archivo o proveedor (institución o persona)
            $table->string('location')->nullable();    // Ubicación geográfica
            $table->string('resolution')->nullable();
            $table->string('format')->nullable();      // JPG, PNG, TIFF, etc.
            $table->text('descriptors')->nullable();   // Palabras clave

            // Archivo físico
            $table->string('thumbnail_path')->nullable();
            $table->string('full_image_path')->nullable();

            // Fuente de acceso
            $table->enum('source_type', ['local', 'external', 'none'])->default('none');
            $table->text('external_url')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('photos');
    }
};
