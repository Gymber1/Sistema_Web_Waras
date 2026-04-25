<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('descriptors', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->string('slug', 100)->unique();
            $table->timestamps();
        });

        Schema::create('book_descriptor', function (Blueprint $table) {
            $table->foreignId('book_id')->constrained()->cascadeOnDelete();
            $table->foreignId('descriptor_id')->constrained()->cascadeOnDelete();
            $table->primary(['book_id', 'descriptor_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('book_descriptor');
        Schema::dropIfExists('descriptors');
    }
};
