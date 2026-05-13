<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class Dashboard extends BaseDashboard
{
    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                ...(method_exists($this, 'getFiltersForm') ? [$this->getFiltersFormContentComponent()] : []),
                Grid::make([
                    'default' => 1,
                    'xl' => 2,
                ])
                    ->schema([
                        Grid::make(1)
                            ->schema($this->getWidgetsSchemaComponents([
                                \App\Filament\Widgets\ModeloReporteWidget::class,
                            ])),
                        Grid::make(1)
                            ->schema($this->getWidgetsSchemaComponents([
                                \App\Filament\Widgets\ImpactoCostosWidget::class,
                                \App\Filament\Widgets\CostoEngordeWidget::class,
                                \App\Filament\Widgets\TasaMaizWidget::class,
                            ])),
                    ]),
            ]);
    }

    /**
     * @return int | array<string, ?int>
     */
    public function getColumns(): int | array
    {
        return [
            'default' => 1,
            'xl' => 2,
        ];
    }

    /**
     * @return array<class-string<\Filament\Widgets\Widget> | \Filament\Widgets\WidgetConfiguration>
     */
    public function getWidgets(): array
    {
        return [
            \App\Filament\Widgets\ModeloReporteWidget::class,
            \App\Filament\Widgets\ImpactoCostosWidget::class,
            \App\Filament\Widgets\CostoEngordeWidget::class,
            \App\Filament\Widgets\TasaMaizWidget::class,
        ];
    }
}