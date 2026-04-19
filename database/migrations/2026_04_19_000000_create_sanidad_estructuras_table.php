<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sanidad_estructuras', function (Blueprint $table) {
            $table->id();
            $table->string('tipo');
            $table->text('motivo');
            $table->decimal('costo_mes', 10, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sanidad_estructuras');
    }
};