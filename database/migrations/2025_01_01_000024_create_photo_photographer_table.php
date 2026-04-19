<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('photo_photographer', function (Blueprint $table) {
            $table->id();
            $table->foreignId('photo_id')->constrained('photos')->onDelete('cascade');
            $table->foreignId('photographer_id')->constrained('photographers')->onDelete('cascade');
            $table->unsignedInteger('order')->default(1);
            $table->timestamps();

            $table->unique(['photo_id', 'photographer_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('photo_photographer');
    }
};
