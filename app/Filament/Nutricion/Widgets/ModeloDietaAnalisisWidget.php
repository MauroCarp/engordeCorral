<?php

namespace App\Filament\Nutricion\Widgets;

use App\Filament\Widgets\Concerns\InteractsWithModeloReporteData;
use App\Support\ModeloDietaAnalisisCalculator;
use Filament\Widgets\Widget;

class ModeloDietaAnalisisWidget extends Widget
{
    use InteractsWithModeloReporteData;

    protected string $view = 'filament.nutricion.widgets.modelo-dieta-analisis-widget';

    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 1;

    public function mount(): void
    {
        $this->initializeModeloReporteState();
    }

    protected function getViewData(): array
    {
        return app(ModeloDietaAnalisisCalculator::class)->calculate($this->modelo);
    }
}