<?php

namespace App\Filament\Nutricion\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationLabel = 'Nutricion';

    protected static ?string $title = 'Nutricion';

    /**
     * @return array<class-string<\Filament\Widgets\Widget> | \Filament\Widgets\WidgetConfiguration>
     */
    public function getWidgets(): array
    {
        return [
            \App\Filament\Nutricion\Widgets\ModeloDietaAnalisisWidget::class,
        ];
    }
}