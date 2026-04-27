<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('floating_buttons', function (Blueprint $table) {
            $table->string('glow_color')->default('indigo')->after('logo');
        });
    }

    public function down(): void
    {
        Schema::table('floating_buttons', function (Blueprint $table) {
            $table->dropColumn('glow_color');
        });
    }
};
