<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->enum('section', ['Biblioteca Digital', 'Waras Editorial'])
                  ->default('Biblioteca Digital')
                  ->after('document_type');
            $table->string('imprint', 500)->nullable()->after('summary'); // Pie de imprenta
        });
    }

    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn(['section', 'imprint']);
        });
    }
};
