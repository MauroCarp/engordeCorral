<?php

namespace App\Filament\Nutricion\Resources\Insumos\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;

class InsumosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('insumo')
                    ->label('Insumo')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                    
                TextColumn::make('tipo')
                    ->label('Tipo')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Forraje' => 'success',
                        'Concentrado' => 'primary',
                        'Mineral' => 'warning',
                        'Grano' => 'info',
                        default => 'gray',
                    })
                    ->sortable(),
                    
                TextColumn::make('precio')
                    ->label('Precio')
                    ->money('ARS', locale: 'es')
                    ->sortable(),
                    
                TextColumn::make('porceMS')
                    ->label('MS %')
                    ->numeric(decimalPlaces: 2)
                    ->suffix('%')
                    ->sortable(),
                    
                TextColumn::make('Pr')
                    ->label('Proteína %')
                    ->numeric(decimalPlaces: 2)
                    ->suffix('%')
                    ->sortable(),
                    
                TextColumn::make('EE')
                    ->label('EE %')
                    ->numeric(decimalPlaces: 2)
                    ->suffix('%')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                    
                TextColumn::make('DMS')
                    ->label('DMS %')
                    ->numeric(decimalPlaces: 2)
                    ->suffix('%')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                    
                TextColumn::make('EM')
                    ->label('EM')
                    ->numeric(decimalPlaces: 2)
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                    
                TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                    
                TextColumn::make('updated_at')
                    ->label('Actualizado')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('tipo')
                    ->label('Tipo de Insumo')
                    ->options([
                        'Forraje' => 'Forraje',
                        'Concentrado' => 'Concentrado',
                        'Mineral' => 'Mineral',
                        'Vitamina' => 'Vitamina',
                        'Subproducto' => 'Subproducto',
                        'Grano' => 'Grano',
                        'Heno' => 'Heno',
                        'Silaje' => 'Silaje',
                        'Pastura' => 'Pastura',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
