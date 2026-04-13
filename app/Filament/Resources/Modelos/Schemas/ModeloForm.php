<?php

namespace App\Filament\Resources\Modelos\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ModeloForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nombre')
                    ->label('Nombre del modelo')
                    ->placeholder('Ej: Modelo General 2026')
                    ->maxLength(191)
                    ->columnSpanFull(),

                Section::make('Precios')
                    ->columns(3)
                    ->schema([
                        TextInput::make('precio_venta_faena')
                            ->label('Precio venta a faena ($/kg)')
                            ->numeric()
                            ->required()
                            ->default(5200)
                            ->step(0.01),

                        TextInput::make('precio_compra_ternero')
                            ->label('Precio compra terneras/os destete ($/kg)')
                            ->numeric()
                            ->required()
                            ->default(6500)
                            ->step(0.01),

                        TextInput::make('precio_alimento_balanceado')
                            ->label('Precio tal cual alimento balanceado ($/kg)')
                            ->numeric()
                            ->required()
                            ->default(196)
                            ->step(0.01),
                    ]),

                Section::make('Parámetros productivos')
                    ->columns(3)
                    ->schema([
                        TextInput::make('peso_neto_entrada')
                            ->label('Peso neto de entrada (kg)')
                            ->numeric()
                            ->required()
                            ->default(160)
                            ->step(0.01),

                        TextInput::make('peso_neto_venta')
                            ->label('Peso neto venta (kg)')
                            ->numeric()
                            ->required()
                            ->default(380)
                            ->step(0.01),

                        TextInput::make('mortandad')
                            ->label('Mortandad (ej: 0.01 = 1%)')
                            ->numeric()
                            ->required()
                            ->default(0.01)
                            ->step(0.0001),

                        TextInput::make('consumo_promedio_ms')
                            ->label('Consumo promedio MS en terminación (% PV)')
                            ->numeric()
                            ->required()
                            ->default(0.03)
                            ->step(0.0001),

                        TextInput::make('eficiencia_conversion')
                            ->label('Eficiencia conversión (kg MS/kg ganado)')
                            ->numeric()
                            ->required()
                            ->default(7)
                            ->step(0.01),
                    ]),

                Section::make('Cabezas por jaula')
                    ->columns(2)
                    ->schema([
                        TextInput::make('cabezas_jaula_compra')
                            ->label('Cabezas/jaula (referencia compra)')
                            ->numeric()
                            ->integer()
                            ->required()
                            ->default(65),

                        TextInput::make('cabezas_jaula_venta')
                            ->label('Cabezas/jaula (referencia venta)')
                            ->numeric()
                            ->integer()
                            ->required()
                            ->default(50),
                    ]),

                Section::make('Fletes y comercialización')
                    ->columns(3)
                    ->schema([
                        TextInput::make('flete_compra_km')
                            ->label('Flete compra - distancia (km)')
                            ->numeric()
                            ->required()
                            ->default(3737)
                            ->step(0.01),

                        TextInput::make('flete_compra_precio')
                            ->label('Flete compra - precio total ($)')
                            ->numeric()
                            ->required()
                            ->default(600)
                            ->step(0.01),

                        TextInput::make('flete_venta')
                            ->label('Flete venta ($/cabeza)')
                            ->numeric()
                            ->required()
                            ->default(70)
                            ->step(0.01),

                        TextInput::make('gastos_compra')
                            ->label('Gastos de compra (ej: 0.03 = 3%)')
                            ->numeric()
                            ->required()
                            ->default(0.03)
                            ->step(0.0001),

                        TextInput::make('gastos_venta')
                            ->label('Gastos de venta (ej: 0.03 = 3%)')
                            ->numeric()
                            ->required()
                            ->default(0.03)
                            ->step(0.0001),
                    ]),

                Section::make('Costo financiero')
                    ->columns(3)
                    ->schema([
                        TextInput::make('tasa_anual')
                            ->label('Tasa anual (ej: 0.25 = 25%)')
                            ->numeric()
                            ->required()
                            ->default(0.25)
                            ->step(0.0001),

                        TextInput::make('plazo_compra_hacienda')
                            ->label('Plazo compra hacienda (días)')
                            ->numeric()
                            ->integer()
                            ->required()
                            ->default(30),

                        TextInput::make('plazo_venta_hacienda')
                            ->label('Plazo venta hacienda (días)')
                            ->numeric()
                            ->integer()
                            ->required()
                            ->default(10),

                        TextInput::make('dias_financiamiento_alimento')
                            ->label('Días de financiamiento alimento')
                            ->numeric()
                            ->integer()
                            ->required()
                            ->default(60),
                    ]),
            ]);
    }
}
