<?php

namespace App\Filament\Resources\MotivoSanidadEstructuras\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class MotivoSanidadEstructuraForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('motivo')
                    ->required()
                    ->maxLength(255)
                    ->label('Motivo'),

                Select::make('tipo')
                    ->required()
                    ->options([
                        'sanidad' => 'Sanidad',
                        'estructura' => 'Estructura',
                    ])
                    ->label('Tipo'),
            ]);
    }
}