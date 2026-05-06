<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('photos', function (Blueprint $table) {
            $table->string('year_type', 10)->default('exact')->after('year');
            $table->unsignedSmallInteger('year_from')->nullable()->after('year_type');
            $table->unsignedSmallInteger('year_to')->nullable()->after('year_from');
        });
    }

    public function down(): void
    {
        Schema::table('photos', function (Blueprint $table) {
            $table->dropColumn(['year_type', 'year_from', 'year_to']);
        });
    }
};