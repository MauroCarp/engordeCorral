<?php

namespace App\Filament\Resources\SanidadEstructuras\Widgets;

use App\Models\SanidadEstructura;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class EstructuraListWidget extends BaseWidget
{
    protected static ?string $heading = 'Registros de Estructura';

    protected int | string | array $columnSpan = 'half';

    public function table(Table $table): Table
    {
        return $table
            ->query(SanidadEstructura::query()->where(['tipo' => 'estructura']))
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
            ->emptyStateHeading('No hay registros de Estructura')
            ->emptyStateDescription('Crea el primer registro de estructura desde el botón "Nuevo Registro".')
            ->paginated(false)
            ->searchable(false);
    }
}