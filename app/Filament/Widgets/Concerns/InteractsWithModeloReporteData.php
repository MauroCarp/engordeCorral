<?php

namespace App\Filament\Widgets\Concerns;

use App\Models\Modelo;
use App\Models\SanidadEstructura;
use App\Support\ModeloReporteCalculator;
use Illuminate\Support\Collection;
use stdClass;

trait InteractsWithModeloReporteData
{
    public ?Modelo $modelo = null;

    public ?int $selectedModeloId = null;

    /** @var Collection<int, SanidadEstructura> */
    public Collection $sanidadEstructura;

    public stdClass $sanEst;

    public array $modeloOptions = [];

    protected function initializeModeloReporteState(bool $loadModeloOptions = false): void
    {
        $this->sanidadEstructura = collect();
        $this->sanEst = (object) [
            'estructura' => collect(),
            'sanidad' => collect(),
        ];

        if ($loadModeloOptions) {
            $this->modeloOptions = Modelo::query()
                ->orderBy('nombre')
                ->pluck('nombre', 'id')
                ->toArray();
        }

        $sessionModeloId = session($this->getSelectedModeloSessionKey());

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
            session([$this->getSelectedModeloSessionKey() => $this->selectedModeloId]);
        } else {
            session()->forget($this->getSelectedModeloSessionKey());
        }

        $this->syncSanidadData($this->selectedModeloId);
    }

    /**
     * @return array<string, float>
     */
    protected function getModeloReporteViewData(): array
    {
        return app(ModeloReporteCalculator::class)->calculate($this->modelo, $this->sanEst);
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

    private function getSelectedModeloSessionKey(): string
    {
        return 'selected_modelo_id';
    }
}