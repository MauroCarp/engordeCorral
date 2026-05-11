<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class ImpactoCostosWidget extends Widget
{
    protected string $view = 'filament.widgets.impacto-costos-widget';

    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 2;
}
