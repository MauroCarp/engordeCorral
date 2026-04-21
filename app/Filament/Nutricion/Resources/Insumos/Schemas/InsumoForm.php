<?php

namespace App\Filament\Nutricion\Resources\Insumos\Schemas;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class InsumoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Información Básica')
                    ->schema([
                        TextInput::make('insumo')
                            ->label('Nombre del Insumo')
                            ->required()
                            ->maxLength(150),
                            
                        Select::make('tipo')
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
                            ])
                            ->required()
                            ->searchable(),
                            
                        TextInput::make('precio')
                            ->label('Precio')
                            ->numeric()
                            ->step(0.01)
                            ->prefix('$'),
                    ]),
                    
                Section::make('Composición Nutricional')
                    ->schema([
                        TextInput::make('porceMS')
                            ->label('Materia Seca (%)')
                            ->numeric()
                            ->step(0.01)
                            ->suffix('%'),
                            
                        TextInput::make('DMS')
                            ->label('Digestibilidad MS (%)')
                            ->numeric()
                            ->step(0.01)
                            ->suffix('%'),
                            
                        TextInput::make('EE')
                            ->label('Extracto Etéreo (%)')
                            ->numeric()
                            ->step(0.01)
                            ->suffix('%'),
                            
                        TextInput::make('Pr')
                            ->label('Proteína (%)')
                            ->numeric()
                            ->step(0.01)
                            ->suffix('%'),
                            
                        TextInput::make('PBa')
                            ->label('Proteína Degradable (%)')
                            ->numeric()
                            ->step(0.01)
                            ->suffix('%'),
                            
                        TextInput::make('PBb')
                            ->label('Proteína No Degradable (%)')
                            ->numeric()
                            ->step(0.01)
                            ->suffix('%'),
                            
                        TextInput::make('H')
                            ->label('Hidratos (%)')
                            ->numeric()
                            ->step(0.01)
                            ->suffix('%'),
                            
                        TextInput::make('NIDA')
                            ->label('NIDA (%)')
                            ->numeric()
                            ->step(0.01)
                            ->suffix('%'),
                            
                        TextInput::make('EM')
                            ->label('Energía Metabolizable')
                            ->numeric()
                            ->step(0.01),
                    ])
                    ->columns(2)
            ]);
    }
}
