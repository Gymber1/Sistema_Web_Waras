<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->string('city', 150)->nullable()->after('imprint');
            $table->string('editorial_name', 255)->nullable()->after('city');
            $table->string('publication_year', 4)->nullable()->after('publication_date');
        });
    }

    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn(['city', 'editorial_name', 'publication_year']);
        });
    }
};
