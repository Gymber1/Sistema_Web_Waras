<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Datos biográficos generales para autores (equivalentes a los de fotógrafos/donadores).
     */
    public function up(): void
    {
        Schema::table('authors', function (Blueprint $table) {
            $table->string('birth_place')->nullable()->after('slug');
            $table->date('birth_date')->nullable()->after('birth_place');
            $table->string('death_place')->nullable()->after('birth_date');
            $table->date('death_date')->nullable()->after('death_place');
            $table->string('occupation')->nullable()->after('death_date');
            $table->text('studies_critique')->nullable()->after('biography');
        });
    }

    public function down(): void
    {
        Schema::table('authors', function (Blueprint $table) {
            $table->dropColumn([
                'birth_place',
                'birth_date',
                'death_place',
                'death_date',
                'occupation',
                'studies_critique',
            ]);
        });
    }
};
