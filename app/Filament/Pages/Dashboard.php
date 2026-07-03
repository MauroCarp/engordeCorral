<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\View;
use Filament\Schemas\Schema;

class Dashboard extends BaseDashboard
{
    public function getTitle(): string
    {
        return '';
    }

    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                ...(method_exists($this, 'getFiltersForm') ? [$this->getFiltersFormContentComponent()] : []),
                View::make('filament.pages.dashboard-tabs')
                    ->columnSpanFull()
                    ->schema([
                        Grid::make(1)
                            ->extraAttributes([
                                'x-show' => 'activeTab === 0',
                                'x-cloak' => '1',
                                'class' => 'dashboard-tabs__panel',
                            ])
                            ->schema($this->getWidgetsSchemaComponents([
                                \App\Filament\Widgets\ModeloReporteWidget::class,
                            ])),
                        Grid::make([
                            'default' => 1,
                            'xl'=>4,
                            ])
                            ->extraAttributes([
                                'x-show' => 'activeTab === 1',
                                'x-cloak' => '1',
                                'class' => 'dashboard-tabs__panel dashboard-costs-grid',
                            ])
                            ->schema([
                                Grid::make(1)
                                    ->extraAttributes(['class' => 'dashboard-widget-group'])
                                    ->schema($this->getWidgetsSchemaComponents([
                                        \App\Filament\Widgets\ImpactoCostosChartWidget::class,
                                        \App\Filament\Widgets\ImpactoCostosWidget::class,
                                    ])),
                                Grid::make(1)
                                    ->extraAttributes(['class' => 'dashboard-widget-group'])
                                    ->schema($this->getWidgetsSchemaComponents([
                                        \App\Filament\Widgets\CostoEngordeChartWidget::class,
                                        \App\Filament\Widgets\CostoEngordeWidget::class,
                                    ]))
                                    ->columnSpan([
                                        'default' => 1,
                                        'xl' => 2,
                                    ]),
                                Grid::make(1)
                                    ->extraAttributes(['class' => 'dashboard-widget-group'])
                                    ->schema($this->getWidgetsSchemaComponents([
                                        \App\Filament\Widgets\EstructuraCostoChartWidget::class,
                                        \App\Filament\Widgets\EstructuraCostoWidget::class,
                                    ])),
                            ]),
                        Grid::make([
                            'default' => 1,
                            'xl'=>1,
                            ])
                            ->extraAttributes([
                                'x-show' => 'activeTab === 2',
                                'x-cloak' => '1',
                                'class' => 'dashboard-tabs__panel',
                            ])
                            ->schema([
                                Grid::make(2)
                                ->extraAttributes(['class' => 'dashboard-widget-group'])
                                ->schema($this->getWidgetsSchemaComponents([
                                    \App\Filament\Widgets\TasaMaizWidget::class,
                                    \App\Filament\Widgets\SensibilidadPreciosWidget::class,
                                ]))
                            ]),
                    ]),
            ]);
    }

    /**
     * @return int | array<string, ?int>
     */
    public function getColumns(): int | array
    {
        return 1;
    }

    /**
     * @return array<class-string<\Filament\Widgets\Widget> | \Filament\Widgets\WidgetConfiguration>
     */
    public function getWidgets(): array
    {
        return [
            \App\Filament\Widgets\ModeloReporteWidget::class,
            \App\Filament\Widgets\ImpactoCostosWidget::class,
            \App\Filament\Widgets\ImpactoCostosChartWidget::class,
            \App\Filament\Widgets\CostoEngordeWidget::class,
            \App\Filament\Widgets\CostoEngordeChartWidget::class,
            \App\Filament\Widgets\EstructuraCostoWidget::class,
            \App\Filament\Widgets\EstructuraCostoChartWidget::class,
            \App\Filament\Widgets\TasaMaizWidget::class,
            \App\Filament\Widgets\SensibilidadPreciosWidget::class,
        ];
    }
}
