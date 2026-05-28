<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donor_special', function (Blueprint $table) {
            $table->id();
            $table->foreignId('donor_id')->constrained('donors')->onDelete('cascade');
            $table->foreignId('special_id')->constrained('specials')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['donor_id', 'special_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donor_special');
    }
};
