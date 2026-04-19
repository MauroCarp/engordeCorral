<?php

namespace App\Filament\Resources\SanidadEstructuras\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class SanidadEstructuraForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('tipo')
                    ->required()
                    ->maxLength(255)
                    ->label('Tipo'),

                Textarea::make('motivo')
                    ->required()
                    ->rows(3)
                    ->label('Motivo'),

                TextInput::make('costo_mes')
                    ->required()
                    ->numeric()
                    ->inputMode('decimal')
                    ->step(0.01)
                    ->prefix('$')
                    ->label('Costo por Mes'),
            ]);
    }
}