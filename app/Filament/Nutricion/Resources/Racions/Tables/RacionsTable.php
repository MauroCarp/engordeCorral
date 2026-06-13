<?php

namespace App\Filament\Nutricion\Resources\Racions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RacionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nombre')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('composicion_texto')
                    ->label('Insumos')
                    ->wrap()
                    ->toggleable(),
                TextColumn::make('porcentaje_ms')
                    ->label('% MS')
                    ->numeric(decimalPlaces: 2, decimalSeparator: ',', thousandsSeparator: '.')
                    ->suffix('%')
                    ->sortable(),
                TextColumn::make('costo_kg_tc')
                    ->label('$/Kg TC')
                    // ->money('ARS', divideBy: 1)
                    ->prefix('$')
                    ->numeric(decimalPlaces: 1, decimalSeparator: ',', thousandsSeparator: '.')
                    ->sortable(),
                TextColumn::make('costo_kg_ms')
                    ->label('$/Kg MS')
                    // ->money('ARS', divideBy: 1)
                    ->prefix('$')
                    ->numeric(decimalPlaces: 1, decimalSeparator: ',', thousandsSeparator: '.')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
