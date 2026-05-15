<?php

namespace App\Filament\Widgets;

use App\Models\Modelo;
use App\Models\SanidadEstructura;
use Filament\Widgets\Widget;
use Illuminate\Support\Collection;

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

    public array $modeloOptions = [];

    public function boot(): void
    {
        $this->sanidadEstructura = collect();
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

        $this->sanidadEstructura = $this->selectedModeloId
            ? SanidadEstructura::where('modelo_id', $this->selectedModeloId)->get()
            : collect();
    }

    public function updatedSelectedModeloId(?int $value): void
    {
        if (! $value) {
            $this->modelo = null;
            session()->forget(self::SELECTED_MODELO_SESSION_KEY);

            return;
        }

        $this->modelo = Modelo::find($value);

        if ($this->modelo) {
            session([self::SELECTED_MODELO_SESSION_KEY => $this->modelo->id]);
        }

        $this->sanidadEstructura = $this->modelo
            ? SanidadEstructura::where('modelo_id', $this->modelo->id)->get()
            : collect();
    }
}