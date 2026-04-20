<?php

namespace App\Filament\Resources\SanidadEstructuras\Widgets;

use App\Models\SanidadEstructura;
use Filament\Support\Facades\FilamentView;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class SanidadListWidget extends BaseWidget
{
    protected static ?string $heading = 'Registros de Sanidad';

    protected int | string | array $columnSpan = 'half';

    public function table(Table $table): Table
    {
        return $table
            ->query(SanidadEstructura::query()->where('tipo', 'sanidad'))
            ->columns([
                TextColumn::make('motivo')
                    ->label('Motivo')
                    ->limit(50)
                    ->searchable(),

                TextColumn::make('costo_mes')
                    ->label('Costo por Mes')
                    ->money('ARS',false,false,0)
                    ->sortable()
                    ->summarize([
                        \Filament\Tables\Columns\Summarizers\Sum::make()
                            ->money('ARS',false,false,0)
                            ->label('Total $/Mes'),
                    ]),
            ])
            ->emptyStateHeading('No hay registros de Sanidad')
            ->emptyStateDescription('Crea el primer registro de sanidad desde el botón "Nuevo Registro".')
            ->paginated(false)
            ->searchable(false);
    }
}