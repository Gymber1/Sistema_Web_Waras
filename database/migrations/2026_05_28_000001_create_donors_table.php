<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donors', function (Blueprint $table) {
            $table->id();
            $table->string('full_name', 255);
            $table->string('slug', 255)->unique();
            $table->string('birth_place')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('death_place')->nullable();
            $table->date('death_date')->nullable();
            $table->text('biography')->nullable();
            $table->text('studies_critique')->nullable();
            $table->string('photo_path')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donors');
    }
};
