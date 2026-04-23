<?php

namespace App\Filament\Resources\Modelos\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ModelosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nombre')
                    ->label('Nombre del Modelo')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                    
                TextColumn::make('precio_venta_faena')
                    ->label('Precio Venta')
                    ->money('ARS')
                    ->sortable(),
                    
                TextColumn::make('precio_compra_ternero')
                    ->label('Precio Compra')
                    ->money('ARS')
                    ->sortable(),
                    
                TextColumn::make('peso_neto_entrada')
                    ->label('Peso Inicial')
                    ->numeric(0)
                    ->suffix(' kg')
                    ->sortable(),
                    
                TextColumn::make('peso_neto_venta')
                    ->label('Peso Final')
                    ->numeric(0)
                    ->suffix(' kg')
                    ->sortable(),
                    
                TextColumn::make('ganancia_estimada')
                    ->label('Ganancia')
                    ->state(fn ($record) => $record->peso_neto_venta - $record->peso_neto_entrada)
                    ->numeric(0)
                    ->suffix(' kg')
                    ->color('success'),
                    
                TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make()
                    ->label('Ver Análisis')
                    ->color('success')
                    ->icon('heroicon-o-chart-bar'),
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
