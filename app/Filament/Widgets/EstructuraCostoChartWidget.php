<?php

namespace App\Filament\Widgets;

use App\Filament\Widgets\Concerns\InteractsWithModeloReporteData;
use Filament\Widgets\Widget;

class EstructuraCostoChartWidget extends Widget
{
    use InteractsWithModeloReporteData;

    protected string $view = 'filament.widgets.estructura-costo-chart-widget';

    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 6;

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
