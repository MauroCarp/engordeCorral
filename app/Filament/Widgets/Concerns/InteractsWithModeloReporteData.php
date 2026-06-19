<?php

namespace App\Filament\Widgets\Concerns;

use App\Models\Modelo;
use App\Models\SanidadEstructura;
use App\Support\ModeloDietaAnalisisCalculator;
use App\Support\ModeloReporteCalculator;
use App\Support\SelectedModeloResolver;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;
use stdClass;

trait InteractsWithModeloReporteData
{
    public ?Modelo $modelo = null;

    public ?int $selectedModeloId = null;

    /** @var Collection<int, SanidadEstructura> */
    public Collection $sanidadEstructura;

    public stdClass $sanEst;

    /**
     * @var array{modelo:?Modelo,rows:array<int, array<string, float|string>>,averages:array<string, float>,rowCount:int}
     */
    public array $dietaAnalisis;

    public array $modeloOptions = [];

    public int $widgetRefreshKey = 0;

    protected function initializeModeloReporteState(bool $loadModeloOptions = false): void
    {
        $this->sanidadEstructura = collect();
        $this->sanEst = (object) [
            'estructura' => collect(),
            'sanidad' => collect(),
        ];
        $this->dietaAnalisis = app(ModeloDietaAnalisisCalculator::class)->calculate(null);

        if ($loadModeloOptions) {
            $this->modeloOptions = Modelo::query()
                ->orderBy('nombre')
                ->pluck('nombre', 'id')
                ->toArray();
        }

        $sessionModeloId = session(SelectedModeloResolver::SESSION_KEY);

        $this->setSelectedModelo($sessionModeloId ? (int) $sessionModeloId : null, fallbackToLatest: true);
    }

    protected function setSelectedModelo(?int $modeloId, bool $fallbackToLatest = false): void
    {
        if ($modeloId) {
            $this->modelo = Modelo::find($modeloId);
        } elseif ($fallbackToLatest) {
            $this->modelo = Modelo::latest()->first();
        } else {
            $this->modelo = null;
        }

        $this->selectedModeloId = $this->modelo?->id;

        if ($this->selectedModeloId) {
            SelectedModeloResolver::set($this->selectedModeloId);
        } else {
            SelectedModeloResolver::set(null);
        }

        $this->syncSanidadData($this->selectedModeloId);
        $this->syncDietaAnalisisData();
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

    /**
     * @return array<string, mixed>
     */
    protected function getModeloReporteViewData(): array
    {
        return array_merge(
            app(ModeloReporteCalculator::class)->calculate($this->modelo, $this->sanEst),
            [
                'dietaAnalisis' => $this->dietaAnalisis,
                'dietaRows' => $this->dietaAnalisis['rows'],
                'dietaAverages' => $this->dietaAnalisis['averages'],
                'dietaRowCount' => $this->dietaAnalisis['rowCount'],
            ],
        );
    }

    private function syncSanidadData(?int $modeloId): void
    {
        $this->sanidadEstructura = $modeloId
            ? SanidadEstructura::query()->where('modelo_id', $modeloId)->get()
            : collect();

        $agrupado = $this->sanidadEstructura->groupBy('tipo');

        $this->sanEst = (object) [
            'estructura' => $agrupado->get('estructura', collect())->values(),
            'sanidad' => $agrupado->get('sanidad', collect())->values(),
        ];
    }

    private function syncDietaAnalisisData(): void
    {
        $this->dietaAnalisis = app(ModeloDietaAnalisisCalculator::class)->calculate($this->modelo);
    }
}