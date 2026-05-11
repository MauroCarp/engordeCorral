<?php

namespace App\Filament\Resources\Modelos\Schemas;

use App\Models\Dieta;
use Closure;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
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

                Section::make('Mercado')
                    ->columns(2)
                    ->schema([
                        TextInput::make('precio_compra_ternero')
                            ->label('Precio Compra ($/kg)')
                            ->numeric()
                            ->required()
                            ->default(0)
                            ->step(0.1),
                        TextInput::make('precio_venta_faena')
                            ->label('Precio Venta ($/kg)')
                            ->numeric()
                            ->required()
                            ->default(0)
                            ->step(0.1),
                        TextInput::make('peso_neto_entrada')
                            ->label('Peso Neto Ingreso (kg)')
                            ->numeric()
                            ->required()
                            ->default(0)
                            ->step(0.01),
                        TextInput::make('peso_neto_venta')
                            ->label('Peso Neto Venta (kg)')
                            ->numeric()
                            ->required()
                            ->default(0)
                            ->step(0.01),
                    ]),
                Section::make('Financiero')
                    ->columns(3)
                    ->schema([
                        TextInput::make('tasa_anual')
                            ->label('Tasa anual (%)')
                            ->numeric()
                            ->required()
                            ->default(0)
                            ->step(1),

                        TextInput::make('plazo_compra_hacienda')
                            ->label('Plazo compra (días)')
                            ->numeric()
                            ->integer()
                            ->required()
                            ->default(30),

                        TextInput::make('plazo_venta_hacienda')
                            ->label('Plazo venta (días)')
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


                Section::make('Comercialización')
                    ->columns(2)
                    ->schema([
                        TextInput::make('cabezas_jaula_terneros')
                            ->label('Cabezas/jaula (Terneros/as)')
                            ->numeric()
                            ->integer()
                            ->required()
                            ->default(0),

                        TextInput::make('cabezas_jaula_gordos')
                            ->label('Cabezas/jaula (Gordos/as)')
                            ->numeric()
                            ->integer()
                            ->required()
                            ->default(0),
                        TextInput::make('flete_compra_km')
                            ->label('Flete compra (km)')
                            ->numeric()
                            ->required()
                            ->default(0)
                            ->step(1),
                        TextInput::make('flete_venta_km')
                            ->label('Flete venta (km)')
                            ->numeric()
                            ->required()
                            ->default(0)
                            ->step(1),
                        TextInput::make('gastos_compra')
                            ->label('Gastos de compra (%)')
                            ->numeric()
                            ->required()
                            ->default(0)
                            ->step(1),
                        TextInput::make('gastos_venta')
                            ->label('Gastos de venta (%)')
                            ->numeric()
                            ->required()
                            ->default(0)
                            ->step(1),
                        TextInput::make('flete_compra_venta_precio')
                            ->label('Flete Precio ($/km)')
                            ->numeric()
                            ->required()
                            ->default(0)
                            ->step(1),
                    ]),
                Section::make('')
                    ->columns(1)
                    ->schema([
                        Section::make('Sanidad')
                        ->columns(2)
                        ->schema([
                            TextInput::make('mortandad')
                                ->label('Mortandad')
                                ->numeric()
                                ->required()
                                ->default(0)
                                ->step(0.1),
                        ]),
                        Section::make('Nutrición')
                            ->columns(2)
                            ->schema([
                                Repeater::make('dieta')
                                    ->label('Composición de dieta')
                                    ->schema([
                                        Select::make('nombre')
                                            ->label('Dieta')
                                            ->options(fn (): array => Dieta::query()->orderBy('nombre')->pluck('nombre', 'nombre')->all())
                                            ->searchable()
                                            ->preload()
                                            ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                            ->required(),
                                        TextInput::make('porcentaje')
                                            ->label('Porcentaje')
                                            ->numeric()
                                            ->required()
                                            ->minValue(0.01)
                                            ->maxValue(100)
                                            ->step(0.01)
                                            ->suffix('%'),
                                    ])
                                    ->columns(2)
                                    ->columnSpanFull()
                                    ->default([
                                        ['nombre' => null, 'porcentaje' => 100],
                                    ])
                                    ->minItems(1)
                                    ->reorderable(false)
                                    ->addActionLabel('Agregar dieta')
                                    ->helperText('La suma de los porcentajes debe ser exactamente 100.')
                                    ->required()
                                    ->rule(static function (): Closure {
                                        return static function (string $attribute, $value, Closure $fail): void {
                                            if (! is_array($value) || $value === []) {
                                                $fail('Debe cargar al menos una dieta.');

                                                return;
                                            }

                                            $total = 0;

                                            foreach ($value as $item) {
                                                $total += (float) ($item['porcentaje'] ?? 0);
                                            }

                                            if (round($total, 2) !== 100.0) {
                                                $fail('La suma de los porcentajes de las dietas debe ser exactamente 100.');
                                            }
                                        };
                                    }),
                                TextInput::make('precio_alimento_balanceado')
                                    ->label('Precio tal cual alimento balanceado ($/kg)')
                                    ->numeric()
                                    ->required()
                                    ->default(0)
                                    ->step(0.1),
                                TextInput::make('consumo_promedio_ms')
                                    ->label('Consumo promedio MS en terminación (% PV)')
                                    ->numeric()
                                    ->required()
                                    ->default(0)
                                    ->step(0.1),
                                TextInput::make('eficiencia_conversion')
                                    ->label('Eficiencia conversión (kg MS/kg carne)')
                                    ->numeric()
                                    ->required()
                                    ->default(1)
                                    ->step(0.1),
                            ]),
                    ]),

            ]);
    }
}
