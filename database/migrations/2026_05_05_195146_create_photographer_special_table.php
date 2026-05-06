<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('photographer_special', function (Blueprint $table) {
            $table->id();
            $table->foreignId('photographer_id')->constrained()->cascadeOnDelete();
            $table->foreignId('special_id')->constrained()->cascadeOnDelete();
            $table->unique(['photographer_id', 'special_id']);
        });

        // Migrate existing collection_id data to pivot
        if (Schema::hasColumn('photographers', 'collection_id')) {
            \DB::table('photographers')
                ->whereNotNull('collection_id')
                ->get(['id', 'collection_id'])
                ->each(fn($p) => \DB::table('photographer_special')->insertOrIgnore([
                    'photographer_id' => $p->id,
                    'special_id'      => $p->collection_id,
                ]));

            Schema::table('photographers', function (Blueprint $table) {
                $table->dropForeign(['collection_id']);
                $table->dropColumn('collection_id');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('photographer_special');

        Schema::table('photographers', function (Blueprint $table) {
            $table->foreignId('collection_id')->nullable()->constrained('specials')->nullOnDelete();
        });
    }
};