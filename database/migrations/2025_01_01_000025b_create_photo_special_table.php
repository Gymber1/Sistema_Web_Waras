<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('photo_special', function (Blueprint $table) {
            $table->id();
            $table->foreignId('photo_id')->constrained('photos')->onDelete('cascade');
            $table->foreignId('special_id')->constrained('specials')->onDelete('cascade');
            $table->unsignedInteger('order')->default(0);
            $table->timestamps();

            $table->unique(['photo_id', 'special_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('photo_special');
    }
};
