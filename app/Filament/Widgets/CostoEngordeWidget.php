<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class CostoEngordeWidget extends Widget
{
    protected string $view = 'filament.widgets.costo-engorde-widget';

    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 2;
}
