<?php

namespace App\Filament\Widgets;

use App\Models\Modelo;
use Filament\Widgets\Widget;

class ModeloReporteWidget extends Widget
{
    protected string $view = 'filament.widgets.modelo-reporte-widget';

    protected int | string | array $columnSpan = [
        'default' => 'full',
        'xl' => 1,
    ];

    protected static ?int $sort = 1;

    public ?Modelo $modelo = null;

    public function mount(): void
    {
        $this->modelo = Modelo::latest()->first();
    }
}