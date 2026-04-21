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
        Schema::create('insumos', function (Blueprint $table) {
            $table->id();
            $table->string('insumo', 150);
            $table->string('tipo', 100);
            $table->float('precio');
            $table->float('porceMS')->nullable();
            $table->float('DMS')->nullable();
            $table->float('EE')->nullable();
            $table->float('Pr')->nullable();
            $table->float('PBa')->nullable();
            $table->float('PBb')->nullable();
            $table->float('H')->nullable();
            $table->float('NIDA')->nullable();
            $table->float('EM')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insumos');
    }
};
