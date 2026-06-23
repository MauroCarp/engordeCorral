<?php

namespace Tests\Unit;

use App\Models\Modelo;
use App\Models\MotivoSanidadEstructura;
use App\Models\SanidadEstructura;
use App\Support\SanidadEstructuraBootstrapService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SanidadEstructuraBootstrapServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_bootstrap_for_modelo_creates_zero_cost_rows_for_all_motivos(): void
    {
        MotivoSanidadEstructura::query()->create([
            'motivo' => 'Antibiotico',
            'tipo' => 'sanidad',
        ]);

        MotivoSanidadEstructura::query()->create([
            'motivo' => 'Alquiler',
            'tipo' => 'estructura',
        ]);

        $modelo = Modelo::query()->create([
            'nombre' => 'Modelo Test',
            'precio_venta_faena' => 1000,
            'precio_compra_ternero' => 800,
            'precio_alimento_balanceado' => 200,
            'peso_neto_entrada' => 200,
            'peso_neto_venta' => 500,
            'mortandad' => 0.02,
            'consumo_promedio_ms' => 0.03,
            'eficiencia_conversion' => 6,
            'cabezas_jaula_terneros' => 50,
            'cabezas_jaula_gordos' => 50,
            'flete_compra_km' => 100,
            'flete_venta_km' => 100,
            'flete_compra_venta_precio' => 1,
            'gastos_compra' => 0.01,
            'gastos_venta' => 0.01,
            'tasa_anual' => 0.4,
            'plazo_compra_hacienda' => 30,
            'plazo_venta_hacienda' => 10,
            'dias_financiamiento_alimento' => 60,
            'capacidad_estructura' => 100,
        ]);

        $created = app(SanidadEstructuraBootstrapService::class)->bootstrapForModelo($modelo);

        $this->assertSame(2, $created);
        $this->assertDatabaseHas('sanidad_estructuras', [
            'modelo_id' => $modelo->id,
            'tipo' => 'sanidad',
            'motivo' => 'Antibiotico',
            'costo_mes' => 0,
        ]);
        $this->assertDatabaseHas('sanidad_estructuras', [
            'modelo_id' => $modelo->id,
            'tipo' => 'estructura',
            'motivo' => 'Alquiler',
            'costo_mes' => 0,
        ]);
    }

    public function test_sync_missing_motivos_does_not_overwrite_existing_costs(): void
    {
        $modelo = Modelo::query()->create([
            'nombre' => 'Modelo Existente',
            'precio_venta_faena' => 1000,
            'precio_compra_ternero' => 800,
            'precio_alimento_balanceado' => 200,
            'peso_neto_entrada' => 200,
            'peso_neto_venta' => 500,
            'mortandad' => 0.02,
            'consumo_promedio_ms' => 0.03,
            'eficiencia_conversion' => 6,
            'cabezas_jaula_terneros' => 50,
            'cabezas_jaula_gordos' => 50,
            'flete_compra_km' => 100,
            'flete_venta_km' => 100,
            'flete_compra_venta_precio' => 1,
            'gastos_compra' => 0.01,
            'gastos_venta' => 0.01,
            'tasa_anual' => 0.4,
            'plazo_compra_hacienda' => 30,
            'plazo_venta_hacienda' => 10,
            'dias_financiamiento_alimento' => 60,
            'capacidad_estructura' => 100,
        ]);

        MotivoSanidadEstructura::withoutEvents(function () use ($modelo): void {
            MotivoSanidadEstructura::query()->create([
                'motivo' => 'Antibiotico',
                'tipo' => 'sanidad',
            ]);

            MotivoSanidadEstructura::query()->create([
                'motivo' => 'Vacunas',
                'tipo' => 'sanidad',
            ]);
        });

        SanidadEstructura::query()->create([
            'modelo_id' => $modelo->id,
            'tipo' => 'sanidad',
            'motivo' => 'Antibiotico',
            'costo_mes' => 150,
        ]);

        $created = app(SanidadEstructuraBootstrapService::class)->syncMissingMotivosForModelo($modelo);

        $this->assertSame(1, $created);
        $this->assertDatabaseHas('sanidad_estructuras', [
            'modelo_id' => $modelo->id,
            'motivo' => 'Antibiotico',
            'costo_mes' => 150,
        ]);
        $this->assertDatabaseHas('sanidad_estructuras', [
            'modelo_id' => $modelo->id,
            'motivo' => 'Vacunas',
            'costo_mes' => 0,
        ]);
    }

    public function test_backfill_orphan_records_assigns_single_modelo(): void
    {
        $modelo = Modelo::query()->create([
            'nombre' => 'Unico Modelo',
            'precio_venta_faena' => 1000,
            'precio_compra_ternero' => 800,
            'precio_alimento_balanceado' => 200,
            'peso_neto_entrada' => 200,
            'peso_neto_venta' => 500,
            'mortandad' => 0.02,
            'consumo_promedio_ms' => 0.03,
            'eficiencia_conversion' => 6,
            'cabezas_jaula_terneros' => 50,
            'cabezas_jaula_gordos' => 50,
            'flete_compra_km' => 100,
            'flete_venta_km' => 100,
            'flete_compra_venta_precio' => 1,
            'gastos_compra' => 0.01,
            'gastos_venta' => 0.01,
            'tasa_anual' => 0.4,
            'plazo_compra_hacienda' => 30,
            'plazo_venta_hacienda' => 10,
            'dias_financiamiento_alimento' => 60,
            'capacidad_estructura' => 100,
        ]);

        SanidadEstructura::query()->create([
            'modelo_id' => null,
            'tipo' => 'sanidad',
            'motivo' => 'Antibiotico',
            'costo_mes' => 75,
        ]);

        $updated = app(SanidadEstructuraBootstrapService::class)->backfillOrphanRecords();

        $this->assertSame(1, $updated);
        $this->assertDatabaseHas('sanidad_estructuras', [
            'modelo_id' => $modelo->id,
            'motivo' => 'Antibiotico',
            'costo_mes' => 75,
        ]);
    }
}
