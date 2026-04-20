<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('motivo_sanidad_estructuras', function (Blueprint $table) {
            $table->id();
            $table->string('motivo');
            $table->string('tipo');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('motivo_sanidad_estructuras');
    }
};