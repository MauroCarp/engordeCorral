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
        Schema::create('modelos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->nullable();

            // Precios
            $table->decimal('precio_venta_faena', 10, 2)->comment('Precio venta a faena ($/kg)');
            $table->decimal('precio_compra_ternero', 10, 2)->comment('Precio compra terneras/os destete ($/kg)');
            $table->decimal('precio_alimento_balanceado', 10, 2)->comment('Precio tal cual alimento balanceado ($/kg)');

            // Pesos
            $table->decimal('peso_neto_entrada', 8, 2)->comment('Peso neto de entrada (kg)');
            $table->decimal('peso_neto_venta', 8, 2)->comment('Peso neto venta (kg)');

            // Parámetros productivos
            $table->decimal('mortandad', 5, 4)->comment('Mortandad (ej: 0.01 = 1%)');
            $table->decimal('consumo_promedio_ms', 5, 4)->comment('Consumo promedio MS en terminación (% PV)');
            $table->decimal('eficiencia_conversion', 5, 2)->comment('Eficiencia conversión (kg MS/kg ganado)');

            // Cabezas por jaula
            $table->integer('cabezas_jaula_terneros')->comment('Cabezas/jaula (Terneros/as)');
            $table->integer('cabezas_jaula_gordos')->comment('Cabezas/jaula (Gordos/as)');

            // Fletes y comercialización
            $table->decimal('flete_compra_km', 10, 2)->comment('Flete compra (km)');
            $table->decimal('flete_venta_km', 10, 2)->comment('Flete venta (km)');
            $table->decimal('flete_compra_venta_precio', 10, 2)->comment('Flete compra-venta - precio ($/km)');
            $table->decimal('gastos_compra', 5, 4)->comment('Gastos de compra (ej: 0.03 = 3%)');
            $table->decimal('gastos_venta', 5, 4)->comment('Gastos de venta (ej: 0.03 = 3%)');

            // Financiamiento
            $table->decimal('tasa_anual', 5, 4)->comment('Tasa anual (ej: 0.25 = 25%)');
            $table->integer('plazo_compra_hacienda')->comment('Plazo compra hacienda (días)');
            $table->integer('plazo_venta_hacienda')->comment('Plazo venta hacienda (días)');
            $table->integer('dias_financiamiento_alimento')->comment('Días de financiamiento alimento');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modelos');
    }
};
