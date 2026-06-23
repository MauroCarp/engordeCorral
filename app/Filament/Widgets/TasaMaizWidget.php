<?php

namespace App\Filament\Widgets;

use App\Models\Insumo;
use App\Models\Modelo;
use App\Models\SanidadEstructura;
use App\Support\SelectedModeloResolver;
use Filament\Widgets\Widget;
use Livewire\Attributes\On;

class TasaMaizWidget extends Widget
{
    protected string $view = 'filament.widgets.tasa-maiz-widget';

    protected int | string | array $columnSpan = 'half';

    protected static ?int $sort = 4;

    public ?Modelo $modelo = null;

    public float $precioMaiz = 0.0;

    public float $kgProducidos = 0.0;

    /**
     * @var array<int, array<string, mixed>>
     */
    public array $rows = [];

    /**
     * @var array<string, float>
     */
    public array $totals = [
        'column2' => 0.0,
        'column3' => 0.0,
        'column4' => 0.0,
    ];

    public int $widgetRefreshKey = 0;

    public function mount(): void
    {
        $modeloId = SelectedModeloResolver::resolveId();
        $this->setSelectedModelo($modeloId, fallbackToLatest: true);
    }

    #[On('modeloSeleccionado')]
    public function handleModeloSeleccionado(?int $modeloId = null): void
    {
        $this->refreshDashboardWidgets($modeloId);
    }

    #[On('refresh-dashboard-widgets')]
    public function refreshDashboardWidgets(?int $modeloId = null): void
    {
        $this->setSelectedModelo(
            $modeloId ?? SelectedModeloResolver::resolveId(),
            fallbackToLatest: $modeloId === null,
        );
        $this->widgetRefreshKey++;
    }

    public function refreshDashboardWidget(): void
    {
        $this->refreshDashboardWidgets(SelectedModeloResolver::resolveId());
    }

    private function setSelectedModelo(?int $modeloId, bool $fallbackToLatest = false): void
    {
        if ($modeloId) {
            $this->modelo = Modelo::find($modeloId);
        } elseif ($fallbackToLatest) {
            $this->modelo = Modelo::latest()->first();
        } else {
            $this->modelo = null;
        }

        $this->recalculate();
    }

    private function recalculate(): void
    {
        if (! $this->modelo) {
            $this->rows = [];
            $this->totals = [
                'column2' => 0.0,
                'column3' => 0.0,
                'column4' => 0.0,
            ];

            return;
        }

        $this->kgProducidos = max(0, (float) $this->modelo->peso_neto_venta - (float) $this->modelo->peso_neto_entrada);
        $this->precioMaiz = $this->resolvePrecioMaiz();

        $costos = $this->calcularCostosBase($this->modelo);

        $this->rows = $this->buildRows($costos);
        $this->totals = $this->calculateTotals($this->rows);
    }

    private function resolvePrecioMaiz(): float
    {
        $insumoMaiz = Insumo::query()
            ->where('insumo', 'like', '%maiz%')
            ->orderBy('id')
            ->first();

        if ($insumoMaiz) {
            return (float) $insumoMaiz->precio;
        }

        return (float) ($this->modelo?->precio_alimento_balanceado ?? 0);
    }

    /**
     * @return array<string, float>
     */
    private function calcularCostosBase(Modelo $modelo): array
    {
        $kgProducidos = max(0, (float) $modelo->peso_neto_venta - (float) $modelo->peso_neto_entrada);
        $diasEngorde = $kgProducidos > 0 ? max(1, (int) round($kgProducidos / 1.16)) : 1;
        $pesoPromedio = ((float) $modelo->peso_neto_entrada + (float) $modelo->peso_neto_venta) / 2;
        $consumoDiario = $pesoPromedio * (float) $modelo->consumo_promedio_ms;
        $consumoTotalMs = $consumoDiario * $diasEngorde;

        $costoAlimento = $consumoTotalMs * (float) $modelo->precio_alimento_balanceado;

        $sanidadQuery = SanidadEstructura::query()
            ->where('modelo_id', $modelo->id);

        $costoSanidadMensual = (float) (clone $sanidadQuery)
            ->where('tipo', 'sanidad')
            ->sum('costo_mes');

        $costoEstructuraMensual = (float) (clone $sanidadQuery)
            ->where('tipo', 'estructura')
            ->sum('costo_mes');

        return [
            'costo_alimento' => $costoAlimento,
            'costo_sanidad' => $costoSanidadMensual * ($diasEngorde / 30),
            'costo_estructura' => $costoEstructuraMensual * ($diasEngorde / 30),
            'gastos_comercializacion' => ((float) $modelo->gastos_compra + (float) $modelo->gastos_venta),
        ];
    }

    /**
     * @param  array<string, float>  $costos
     * @return array<int, array<string, mixed>>
     */
    private function buildRows(array $costos): array
    {
        $rows = [
            [
                'label' => '$ Maiz',
                'column2' => $this->precioMaiz,
                'column3_label' => 'por Kg Prod.',
                'column4_label' => '%',
                'selectable' => false,
                'checked' => false,
                'kind' => 'info',
            ],
            $this->makeDataRow('Alimentacion', $costos['costo_alimento'], true, true),
            $this->makeDataRow('Sanidad', $costos['costo_sanidad'], true, true),
            $this->makeDataRow('Estructura', $costos['costo_estructura'], true, true),
            $this->makeDataRow('Gs Comercializacion', $costos['gastos_comercializacion'], true, false),
        ];

        return $this->applyPercentages($rows);
    }

    /**
     * @param  array<int, array<string, mixed>>  $rows
     * @return array<int, array<string, mixed>>
     */
    private function applyPercentages(array $rows): array
    {
        $sumColumn3 = 0.0;

        foreach ($rows as $row) {
            if (($row['kind'] ?? null) !== 'data') {
                continue;
            }

            if (! ($row['checked'] ?? false)) {
                continue;
            }

            $sumColumn3 += (float) ($row['column3'] ?? 0);
        }

        foreach ($rows as $index => $row) {
            if (($row['kind'] ?? null) !== 'data') {
                continue;
            }

            $column3 = (float) ($row['column3'] ?? 0);
            $rows[$index]['column4'] = $sumColumn3 > 0 ? ($column3 * 100) / $sumColumn3 : 0.0;
        }

        return $rows;
    }

    /**
     * @return array<string, mixed>
     */
    private function makeDataRow(string $label, float $baseValue, bool $selectable, bool $checked): array
    {
        $column2 = $this->safeDivide($baseValue, $this->precioMaiz);
        $column3 = $this->safeDivide($column2, $this->kgProducidos);

        return [
            'label' => $label,
            'base_value' => $baseValue,
            'column2' => $column2,
            'column3' => $column3,
            'column4' => 0.0,
            'selectable' => $selectable,
            'checked' => $checked,
            'kind' => 'data',
        ];
    }

    /**
     * @param  array<int, array<string, mixed>>  $rows
     * @return array<string, float>
     */
    private function calculateTotals(array $rows): array
    {
        $totals = [
            'column2' => 0.0,
            'column3' => 0.0,
            'column4' => 0.0,
        ];

        foreach ($rows as $row) {
            if (($row['kind'] ?? null) !== 'data') {
                continue;
            }

            if (! ($row['checked'] ?? false)) {
                continue;
            }

            $totals['column2'] += (float) ($row['column2'] ?? 0);
            $totals['column3'] += (float) ($row['column3'] ?? 0);
            $totals['column4'] += (float) ($row['column4'] ?? 0);
        }

        return $totals;
    }

    private function safeDivide(float $value, float $divisor): float
    {
        if ($divisor == 0.0) {
            return 0.0;
        }

        return $value / $divisor;
    }
}
