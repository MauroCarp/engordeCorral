<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sanidad_estructuras', function (Blueprint $table) {
            $table->foreignId('modelo_id')
                ->nullable()
                ->after('id')
                ->constrained('modelos')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('sanidad_estructuras', function (Blueprint $table) {
            $table->dropForeign(['modelo_id']);
            $table->dropColumn('modelo_id');
        });
    }
};
