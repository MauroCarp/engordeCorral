<?php

namespace App\Filament\Widgets;

use App\Filament\Widgets\Concerns\InteractsWithModeloReporteData;
use Filament\Widgets\Widget;

class ImpactoCostosWidget extends Widget
{
    use InteractsWithModeloReporteData;

    protected string $view = 'filament.widgets.impacto-costos-widget';

    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 2;

    protected $listeners = [
        'modeloSeleccionado' => 'handleModeloSeleccionado',
    ];

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
        return $this->getModeloReporteViewData();
    }
}
