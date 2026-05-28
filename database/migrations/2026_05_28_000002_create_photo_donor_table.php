<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('photo_donor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('photo_id')->constrained('photos')->onDelete('cascade');
            $table->foreignId('donor_id')->constrained('donors')->onDelete('cascade');
            $table->unsignedInteger('order')->default(1);
            $table->timestamps();

            $table->unique(['photo_id', 'donor_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('photo_donor');
    }
};
