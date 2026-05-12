<?php

namespace App\Filament\Nutricion\Resources\Racions\Schemas;

use App\Models\Insumo;
use Closure;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
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
                            ->getSelectedRecordUsing(static fn ($state): ?Insumo => filled($state)
                                ? Insumo::query()->find($state)
                                : null)
                            ->searchable()
                            ->preload()
                            ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                            ->createOptionForm(self::insumoOptionFormSchema())
                            ->createOptionUsing(static fn (array $data): int => Insumo::query()->create($data)->getKey())
                            ->createOptionAction(fn ($action) => $action->modalHeading('Nuevo insumo'))
                            ->editOptionForm(self::insumoOptionFormSchema())
                            ->fillEditOptionActionFormUsing(static fn (Select $component): ?array => Insumo::query()
                                ->find($component->getState())
                                ?->attributesToArray())
                            ->updateOptionUsing(static function (array $data, Schema $schema): void {
                                $schema->getRecord()?->update($data);
                            })
                            ->editOptionAction(fn ($action) => $action->modalHeading('Editar insumo'))
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

    protected static function insumoOptionFormSchema(): array
    {
        return [
            TextInput::make('insumo')
                ->label('Insumo')
                ->required()
                ->maxLength(150),
            Select::make('tipo')
                ->label('Tipo')
                ->options(static fn (): array => collect(
                    Insumo::query()
                        ->select('tipo')
                        ->distinct()
                        ->orderBy('tipo')
                        ->pluck('tipo')
                )
                    ->filter()
                    ->mapWithKeys(static fn (string $tipo): array => [$tipo => $tipo])
                    ->all())
                ->searchable()
                ->preload()
                ->required()
                ->native(false),
            Grid::make(2)
                ->schema([
                    TextInput::make('precio')
                        ->label('Precio')
                        ->numeric()
                        ->step(0.01)
                        ->required(),
                    TextInput::make('porceMS')
                        ->label('Materia Seca (%)')
                        ->numeric()
                        ->step(0.01)
                        ->required(),
                    TextInput::make('DMS')
                        ->label('DMS')
                        ->numeric()
                        ->step(0.01)
                        ->default(0)
                        ->required(),
                    TextInput::make('EE')
                        ->label('EE')
                        ->numeric()
                        ->step(0.01)
                        ->default(0)
                        ->required(),
                    TextInput::make('Pr')
                        ->label('Pr')
                        ->numeric()
                        ->step(0.01)
                        ->default(0)
                        ->required(),
                    TextInput::make('PBa')
                        ->label('PBa')
                        ->numeric()
                        ->step(0.01)
                        ->default(0)
                        ->required(),
                    TextInput::make('PBb')
                        ->label('PBb')
                        ->numeric()
                        ->step(0.01)
                        ->default(0)
                        ->required(),
                    TextInput::make('H')
                        ->label('H')
                        ->numeric()
                        ->step(0.01)
                        ->default(0)
                        ->required(),
                    TextInput::make('NIDA')
                        ->label('NIDA')
                        ->numeric()
                        ->step(0.01)
                        ->default(0)
                        ->required(),
                    TextInput::make('EM')
                        ->label('EM')
                        ->numeric()
                        ->step(0.01)
                        ->default(0)
                        ->required(),
                ]),
        ];
    }
}
