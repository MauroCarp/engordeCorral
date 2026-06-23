<?php

namespace App\Filament\Resources\SanidadEstructuras\Schemas;

use App\Models\MotivoSanidadEstructura;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class SanidadEstructuraForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('tipo')
                    ->required()
                    ->options([
                        'sanidad' => 'Sanidad',
                        'estructura' => 'Estructura',
                    ])
                    ->label('Tipo')
                    ->live(),

                Select::make('motivo')
                    ->required()
                    ->options(function (Get $get) {
                        $tipo = $get('tipo');
                        if (!$tipo) {
                            return [];
                        }
                        return MotivoSanidadEstructura::where('tipo', $tipo)
                            ->pluck('motivo', 'motivo')
                            ->toArray();
                    })
                    ->searchable()
                    ->label('Motivo')
                    ->placeholder('Selecciona un tipo primero')
                    ->createOptionUsing(function (array $data, Get $get) {
                        $tipo = $get('tipo');
                        if (!$tipo) {
                            return null;
                        }
                        
                        $motivo = MotivoSanidadEstructura::create([
                            'motivo' => $data['motivo'],
                            'tipo' => $tipo,
                        ]);
                        
                        return $motivo->motivo;
                    })
                    ->createOptionForm([
                        TextInput::make('motivo')
                            ->label('Nuevo Motivo')
                            ->required()
                            ->maxLength(255),
                    ])
                    ->createOptionModalHeading('Agregar Nuevo Motivo'),

                TextInput::make('costo_mes')
                    ->required()
                    ->numeric()
                    ->inputMode('decimal')
                    ->step(0.01)
                    ->prefix('$')
                    ->label(fn (Get $get) => $get('tipo') === 'estructura' ? '$/Mes' : '$/Cab')
                    ->live(),
            ]);
    }

    public static function configureCostoEdit(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('motivo')
                    ->label('Motivo')
                    ->disabled()
                    ->dehydrated(false),

                TextInput::make('tipo')
                    ->label('Tipo')
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'estructura' => 'Estructura',
                        'sanidad' => 'Sanidad',
                        default => (string) $state,
                    })
                    ->disabled()
                    ->dehydrated(false),

                TextInput::make('costo_mes')
                    ->required()
                    ->numeric()
                    ->inputMode('decimal')
                    ->step(0.01)
                    ->prefix('$')
                    ->label(fn (Get $get) => $get('tipo') === 'estructura' ? '$/Mes' : '$/Cab'),
            ]);
    }
}