<?php

namespace App\Filament\Widgets;

use App\Filament\Widgets\Concerns\InteractsWithModeloReporteData;
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

    public function mount(): void
    {
        $this->initializeModeloReporteState(loadModeloOptions: true);
    }

    public function updatedSelectedModeloId(?int $value): void
    {
        $this->setSelectedModelo($value);

        $this->dispatch('modeloSeleccionado', modeloId: $this->selectedModeloId);
    }

    protected function getViewData(): array
    {
        return $this->getModeloReporteViewData();
    }
}