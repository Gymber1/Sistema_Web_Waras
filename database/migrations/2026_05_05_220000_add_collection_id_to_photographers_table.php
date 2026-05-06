<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('photographers', function (Blueprint $table) {
            $table->foreignId('collection_id')->nullable()->constrained('specials')->nullOnDelete()->after('slug');
        });
    }
    public function down(): void {
        Schema::table('photographers', function (Blueprint $table) {
            $table->dropForeignIdFor(\App\Models\Special::class, 'collection_id');
            $table->dropColumn('collection_id');
        });
    }
};