<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('specials', function (Blueprint $table) {
            $table->string('featured_donor')->nullable()->after('description');
        });
    }

    public function down(): void
    {
        Schema::table('specials', function (Blueprint $table) {
            $table->dropColumn('featured_donor');
        });
    }
};
