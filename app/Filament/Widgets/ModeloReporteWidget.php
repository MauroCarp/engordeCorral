<?php

namespace App\Filament\Widgets;

use App\Models\Modelo;
use App\Models\SanidadEstructura;
use Filament\Widgets\Widget;
use Illuminate\Support\Collection;
use stdClass;

class ModeloReporteWidget extends Widget
{
    private const SELECTED_MODELO_SESSION_KEY = 'selected_modelo_id';

    protected string $view = 'filament.widgets.modelo-reporte-widget';

    protected int | string | array $columnSpan = [
        'default' => 'full',
        'xl' => 1,
    ];

    protected static ?int $sort = 1;

    public ?Modelo $modelo = null;
    public ?int $selectedModeloId = null;

    /** @var Collection<int, SanidadEstructura> */
    public Collection $sanidadEstructura;

    public stdClass $sanEst;

    public array $modeloOptions = [];

    public function boot(): void
    {
        $this->sanidadEstructura = collect();
        $this->sanEst = (object) [
            'estructura' => collect(),
            'sanidad' => collect(),
        ];
    }

    public function mount(): void
    {
        $this->modeloOptions = Modelo::query()
            ->orderBy('nombre')
            ->pluck('nombre', 'id')
            ->toArray();

        $sessionModeloId = session(self::SELECTED_MODELO_SESSION_KEY);

        if ($sessionModeloId) {
            $this->modelo = Modelo::find($sessionModeloId);
        }

        if (! $this->modelo) {
            $this->modelo = Modelo::latest()->first();
        }

        $this->selectedModeloId = $this->modelo?->id;

        if ($this->selectedModeloId) {
            session([self::SELECTED_MODELO_SESSION_KEY => $this->selectedModeloId]);
        }

        $this->syncSanidadData($this->selectedModeloId);
    }

    public function updatedSelectedModeloId(?int $value): void
    {
        if (! $value) {
            $this->modelo = null;
            session()->forget(self::SELECTED_MODELO_SESSION_KEY);
            $this->syncSanidadData(null);

            return;
        }

        $this->modelo = Modelo::find($value);

        if ($this->modelo) {
            session([self::SELECTED_MODELO_SESSION_KEY => $this->modelo->id]);
        }

        $this->syncSanidadData($this->modelo?->id);
    }

    private function syncSanidadData(?int $modeloId): void
    {
        $this->sanidadEstructura = $modeloId
            ? SanidadEstructura::where('modelo_id', $modeloId)->get()
            : collect();

        $agrupado = $this->sanidadEstructura->groupBy('tipo');

        $this->sanEst = (object) [
            'estructura' => $agrupado->get('estructura', collect())->values(),
            'sanidad' => $agrupado->get('sanidad', collect())->values(),
        ];
    }
}