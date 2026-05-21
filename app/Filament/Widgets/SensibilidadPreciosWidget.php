<?php

namespace App\Filament\Widgets;

use App\Filament\Widgets\Concerns\InteractsWithModeloReporteData;
use App\Support\ModeloReporteCalculator;
use Filament\Widgets\Widget;

class SensibilidadPreciosWidget extends Widget
{
    use InteractsWithModeloReporteData;

    protected string $view = 'filament.widgets.sensibilidad-precios-widget';

    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = 2;

    protected $listeners = [
        'modeloSeleccionado' => 'handleModeloSeleccionado',
    ];

    /** Porcentajes de variación para el eje de columnas (precio gordo). El 0 es fijo. */
    public array $colPcts = [-10, -5, 0, 5, 10];

    /** Porcentajes de variación para el eje de filas (precio invernada). El 0 es fijo. */
    public array $rowPcts = [-15, -10, -5, 0, 5, 10, 15];

    public function mount(): void
    {
        $this->initializeModeloReporteState();
    }

    public function handleModeloSeleccionado(?int $modeloId = null): void
    {
        $this->setSelectedModelo($modeloId);
    }

    protected function getViewData(): array
    {
        if (! $this->modelo) {
            return [
                'colPcts'         => $this->colPcts,
                'rowPcts'         => $this->rowPcts,
                'gordoHeaders'    => [],
                'invernadaValues' => [],
                'table'           => [],
                'maxAbs'          => 0,
            ];
        }

        $calculator   = app(ModeloReporteCalculator::class);
        $baseData     = $calculator->calculate($this->modelo, $this->sanEst);
        $baseUtilidad = $baseData['utilidadConCostoFinanciero'];

        $baseGordo          = (float) $this->modelo->precio_venta_faena;
        $baseInvernada      = (float) $this->modelo->precio_compra_ternero;
        $pesoEntrada        = (float) $this->modelo->peso_neto_entrada;
        $baseValorInvernada = $baseInvernada * $pesoEntrada;

        $gordoHeaders = [];
        foreach ($this->colPcts as $pct) {
            $gordoHeaders[] = round($baseGordo * (1 + (float) $pct / 100), 2);
        }

        $invernadaValues = [];
        foreach ($this->rowPcts as $pct) {
            $invernadaValues[] = round($baseValorInvernada * (1 + (float) $pct / 100), 2);
        }

        $table  = [];
        $maxAbs = 0;

        foreach ($this->rowPcts as $rowPct) {
            $modInvernada = $baseInvernada * (1 + (float) $rowPct / 100);
            $row = [];

            foreach ($this->colPcts as $colPct) {
                $modGordo    = $baseGordo * (1 + (float) $colPct / 100);
                $modeloClone = clone $this->modelo;

                $modeloClone->precio_compra_ternero = $modInvernada;
                $modeloClone->precio_venta_faena    = $modGordo;

                $calc  = $calculator->calculate($modeloClone, $this->sanEst);
                $delta = (int) round($calc['utilidadConCostoFinanciero'] - $baseUtilidad);
                $row[] = $delta;

                if (abs($delta) > $maxAbs) {
                    $maxAbs = abs($delta);
                }
            }

            $table[] = $row;
        }

        return [
            'colPcts'         => $this->colPcts,
            'rowPcts'         => $this->rowPcts,
            'gordoHeaders'    => $gordoHeaders,
            'invernadaValues' => $invernadaValues,
            'table'           => $table,
            'maxAbs'          => $maxAbs,
        ];
    }
}
