<?php

namespace App\Filament\Nutricion\Resources\Racions\Schemas;

use App\Models\Insumo;
use Closure;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class RacionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nombre')
                    ->label('Nombre')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                Repeater::make('composicion')
                    ->label('Insumos y porcentajes')
                    ->schema([
                        Select::make('insumo')
                            ->label('Insumo')
                            ->options(fn (): array => Insumo::query()->orderBy('insumo')->pluck('insumo', 'id')->all())
                            ->searchable()
                            ->preload()
                            ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                            ->required()
                            ->native(false),
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
                        ['insumo' => null, 'porcentaje' => 100],
                    ])
                    ->minItems(1)
                    ->reorderable(false)
                    ->addActionLabel('Agregar insumo')
                    ->helperText('La suma de los porcentajes debe ser exactamente 100.')
                    ->required()
                    ->rule(static function (): Closure {
                        return static function (string $attribute, $value, Closure $fail): void {
                            if (! is_array($value) || $value === []) {
                                $fail('Debe cargar al menos un insumo.');

                                return;
                            }

                            $total = 0;

                            foreach ($value as $item) {
                                $total += (float) ($item['porcentaje'] ?? 0);
                            }

                            if (round($total, 2) !== 100.0) {
                                $fail('La suma de los porcentajes debe ser exactamente 100.');
                            }
                        };
                    }),
            ]);
    }
}
