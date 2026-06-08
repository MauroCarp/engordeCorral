<?php

namespace App\Filament\Widgets;

use App\Filament\Widgets\Concerns\InteractsWithModeloReporteData;
use App\Models\Modelo;
use App\Support\ModeloReporteCalculator;
use Filament\Widgets\Widget;

class ModeloReporteWidget extends Widget
{
    use InteractsWithModeloReporteData;

    protected string $view = 'filament.widgets.modelo-reporte-widget';

    protected int | string | array $columnSpan = [
        'default' => 'full',
        'xl' => 1,
    ];

    protected static ?int $sort = 1;

    public ?float $breakevenGordo = null;

    public ?float $breakevenInvernada = null;

    public function mount(): void
    {
        $this->initializeModeloReporteState(loadModeloOptions: true);
    }

    public function updatedSelectedModeloId(?int $value): void
    {
        $this->setSelectedModelo($value);
        $this->breakevenGordo = null;
        $this->breakevenInvernada = null;

        $this->dispatch('modeloSeleccionado', modeloId: $this->selectedModeloId);
    }

    /**
     * Calcula el precio mínimo de venta del gordo para cubrir todos los costos
     * (utilidad con costo financiero = 0), manteniendo fijo el precio de compra.
     *
     * Despeje: pvf = fixedCosts / (pesoNetoVenta × (1+mort) × (1−gastosVenta))
     */
    public function calcularBreakevenGordo(): void
    {
        $this->breakevenInvernada = null;

        if (! $this->modelo) {
            $this->breakevenGordo = null;

            return;
        }

        $this->modelo->refresh();
        $this->syncSanidadData($this->selectedModeloId);
        $this->syncDietaAnalisisData();

        $data = app(ModeloReporteCalculator::class)->calculate($this->modelo, $this->sanEst);

        $pesoNetoVenta = (float) $this->modelo->peso_neto_venta;
        $mortandad     = (float) $this->modelo->mortandad;
        $gastosVenta   = (float) $this->modelo->gastos_venta;

        // Costos fijos respecto al precio de venta
        $fixedCosts = $data['valorTerneroInvernada']
            + $data['fleteCompraCab']
            + $data['fleteVentaCab']
            + $data['gastoCompraCab']
            + $data['costoTotalEngordeCab']
            + $data['costoFinancieroTotal'];

        // Contribución neta por unidad de precio de venta
        $netUnits = $pesoNetoVenta * (1 + $mortandad) * (1 - $gastosVenta);

        $this->breakevenGordo = $netUnits > 0 ? round($fixedCosts / $netUnits, 2) : null;
    }

    /**
     * Calcula el precio máximo de compra del ternero invernada para no perder
     * (utilidad con costo financiero = 0), manteniendo fijo el precio de venta.
     *
     * Despeje: pct = numerador / (pesoNetoEntrada × (1+gastosCompra) × (1+rate))
     */
    public function calcularBreakevenInvernada(): void
    {
        $this->breakevenGordo = null;

        if (! $this->modelo) {
            $this->breakevenInvernada = null;

            return;
        }

        $this->modelo->refresh();
        $this->syncSanidadData($this->selectedModeloId);
        $this->syncDietaAnalisisData();

        $data = app(ModeloReporteCalculator::class)->calculate($this->modelo, $this->sanEst);

        $pesoNetoEntrada = (float) $this->modelo->peso_neto_entrada;
        $gastosCompra    = (float) $this->modelo->gastos_compra;
        $rate            = $data['tasaAplicarHacienda'] / 100;

        // Ingresos y costos independientes del precio de compra
        $numerador = $data['valorTerneroGordo']
            - $data['fleteCompraCab'] * (1 + $rate)
            - $data['fleteVentaCab']
            - $data['gastoVentaCab']
            - $data['costoTotalEngordeCab']
            - $data['costoFinancieroAlimento'];

        $denominador = $pesoNetoEntrada * (1 + $gastosCompra) * (1 + $rate);

        $this->breakevenInvernada = $denominador > 0 ? round($numerador / $denominador, 2) : null;
    }

    public function reestablecerBreakeven(): void
    {
        $this->breakevenGordo = null;
        $this->breakevenInvernada = null;
    }

    protected function getModeloParaReporte(): ?Modelo
    {
        if (! $this->modelo) {
            return null;
        }

        if ($this->breakevenGordo === null && $this->breakevenInvernada === null) {
            return $this->modelo;
        }

        $modelo = clone $this->modelo;

        if ($this->breakevenInvernada !== null) {
            $modelo->precio_compra_ternero = $this->breakevenInvernada;
        }

        if ($this->breakevenGordo !== null) {
            $modelo->precio_venta_faena = $this->breakevenGordo;
        }

        return $modelo;
    }

    protected function getViewData(): array
    {
        $modeloReporte = $this->getModeloParaReporte();
        $usaCalculoBreakeven = $this->breakevenGordo !== null || $this->breakevenInvernada !== null;

        return array_merge(
            app(ModeloReporteCalculator::class)->calculate($modeloReporte, $this->sanEst),
            [
                'modeloReporte' => $modeloReporte,
                'usaCalculoBreakeven' => $usaCalculoBreakeven,
                'dietaAnalisis' => $this->dietaAnalisis,
                'dietaRows' => $this->dietaAnalisis['rows'],
                'dietaAverages' => $this->dietaAnalisis['averages'],
                'dietaRowCount' => $this->dietaAnalisis['rowCount'],
            ],
        );
    }
}