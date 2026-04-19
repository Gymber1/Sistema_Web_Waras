<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('book_special', function (Blueprint $table) {
            $table->foreignId('special_id')->constrained()->cascadeOnDelete();
            $table->foreignId('book_id')->constrained()->cascadeOnDelete();
            $table->integer('order')->default(0);
            $table->primary(['special_id', 'book_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('book_special');
    }
};
