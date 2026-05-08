<?php

namespace App\Filament\Resources\Modelos;

use App\Filament\Resources\Modelos\Pages\CreateModelo;
use App\Filament\Resources\Modelos\Pages\EditModelo;
use App\Filament\Resources\Modelos\Pages\ListModelos;
use App\Filament\Resources\Modelos\Pages\ViewModelo;
use App\Filament\Resources\Modelos\Schemas\ModeloForm;
use App\Filament\Resources\Modelos\Tables\ModelosTable;
use Filament\Infolists\Components\Section;
use App\Models\Modelo;
use App\Models\SanidadEstructura;
use BackedEnum;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource; 
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Infolists;
use Filament\Schemas\Components\Section as ComponentsSection;

class ModeloResource extends Resource
{
    protected static ?string $model = Modelo::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $navigationLabel = 'Modelos';

    protected static ?string $modelLabel = 'Modelo';

    protected static ?string $pluralModelLabel = 'Modelos';

    protected static ?string $recordTitleAttribute = 'nombre';

    public static function form(Schema $schema): Schema
    {
        return ModeloForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ModelosTable::configure($table);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
        ->components([
             ComponentsSection::make('Mercado')
                    ->columns(2)
                    ->schema([
                        Infolists\Components\TextEntry::make('precio_venta_faena')
                            ->label('Precio Venta')
                            ->numeric(
                                decimalPlaces: 1,
                                decimalSeparator: ',',
                                thousandsSeparator: '.'
                            )
                            ->suffix(' $/Kg')
                            ->size('lg'),

                        Infolists\Components\TextEntry::make('precio_compra_ternero')
                            ->label('Precio Compra')
                            ->numeric(
                                decimalPlaces: 1,
                                decimalSeparator: ',',
                                thousandsSeparator: '.'
                            )
                            ->suffix(' $/Kg')
                            ->size('lg'),

                        Infolists\Components\TextEntry::make('peso_neto_entrada')
                            ->label('Peso Neto Ingreso')
                            ->numeric(
                                decimalPlaces: 2,
                                decimalSeparator: ',',
                                thousandsSeparator: '.'
                            )
                            ->suffix(' Kg')
                            ->size('lg'),

                        Infolists\Components\TextEntry::make('peso_neto_venta')
                            ->label('Peso Neto Venta')
                            ->numeric(
                                decimalPlaces: 2,
                                decimalSeparator: ',',
                                thousandsSeparator: '.'
                            )
                            ->suffix(' Kg')
                            ->size('lg'),
                    ]),

                ComponentsSection::make('Financiero')
                    ->columns(2)
                    ->schema([
                        Infolists\Components\TextEntry::make('tasa_anual')
                            ->label('Tasa Anual')
                            ->numeric(
                                decimalPlaces: 0,
                                decimalSeparator: ',',
                                thousandsSeparator: '.'
                            )
                            ->suffix('%')
                            ->size('lg'),

                        Infolists\Components\TextEntry::make('plazo_compra_hacienda')
                            ->label('Plazo Compra Hacienda')
                            ->numeric(
                                decimalPlaces: 0
                            )
                            ->suffix(' días')
                            ->size('lg'),

                        Infolists\Components\TextEntry::make('plazo_venta_hacienda')
                            ->label('Plazo Venta Hacienda')
                            ->numeric(
                                decimalPlaces: 0
                            )
                            ->suffix(' días')
                            ->size('lg'),

                        Infolists\Components\TextEntry::make('dias_financiamiento_alimento')
                            ->label('Días de Financiamiento Alimento')
                            ->numeric(
                                decimalPlaces: 0
                            )
                            ->suffix(' días')
                            ->size('lg'),
                    ]),

                ComponentsSection::make('Comercialización')
                    ->columns(2)
                    ->schema([
                        Infolists\Components\TextEntry::make('cabezas_jaula_terneros')
                            ->label('Cabezas/Jaula')
                            ->numeric(
                                decimalPlaces: 0
                            )
                            ->suffix(' Terneros/as')
                            ->size('lg'),

                        Infolists\Components\TextEntry::make('cabezas_jaula_gordos')
                            ->label('Cabezas/Jaula')
                            ->numeric(
                                decimalPlaces: 0
                            )
                            ->suffix(' Gordos/as')
                            ->size('lg'),

                        Infolists\Components\TextEntry::make('flete_compra_km')
                            ->label('Flete Compra (km)')
                            ->numeric(
                                decimalPlaces: 0,
                                decimalSeparator: ',',
                                thousandsSeparator: '.'
                            )
                            ->size('lg'),

                        Infolists\Components\TextEntry::make('flete_venta_km')
                            ->label('Flete Venta (km)')
                            ->numeric(
                                decimalPlaces: 0,
                                decimalSeparator: ',',
                                thousandsSeparator: '.'
                            )
                            ->suffix(' km')
                            ->size('lg'),

                        Infolists\Components\TextEntry::make('flete_compra_venta_precio')
                            ->label('Flete Precio ($/km)')
                            ->numeric(
                                decimalPlaces: 0,
                                decimalSeparator: ',',
                                thousandsSeparator: '.'
                            )
                            ->suffix(' $/Kg')
                            ->size('lg'),

                        Infolists\Components\TextEntry::make('gastos_compra')
                            ->label('Gastos de compra')
                            ->numeric(
                                decimalPlaces: 0,
                                decimalSeparator: ',',
                                thousandsSeparator: '.'
                            )
                            ->suffix(' %')
                            ->size('lg'),

                        Infolists\Components\TextEntry::make('gastos_venta')
                            ->label('Gastos de venta')
                            ->numeric(
                                decimalPlaces: 0,
                                decimalSeparator: ',',
                                thousandsSeparator: '.'
                            )
                            ->suffix(' %')
                            ->size('lg'),
                    ]),

                ComponentsSection::make('')
                    ->columns(2)
                    ->schema([
                        ComponentsSection::make('Sanidad')
                            ->schema([
                                Infolists\Components\TextEntry::make('mortandad')
                                    ->label('Mortandad')
                                    ->numeric(
                                        decimalPlaces: 1,
                                        decimalSeparator: ',',
                                        thousandsSeparator: '.'
                                    )
                                    ->suffix('%')
                                    ->size('lg'),
                            ]),

                        ComponentsSection::make('Nutrición')
                            ->columns(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('precio_alimento_balanceado')
                                    ->label('Precio TC Alimento')
                                    ->numeric(
                                        decimalPlaces: 1,
                                        decimalSeparator: ',',
                                        thousandsSeparator: '.'
                                    )
                                    ->suffix(' $/Kg')
                                    ->size('lg'),

                                Infolists\Components\TextEntry::make('consumo_promedio_ms')
                                    ->label('Consumo Promedio MS en Terminación')
                                    ->numeric(
                                        decimalPlaces: 1,
                                        decimalSeparator: ',',
                                        thousandsSeparator: '.'
                                    )
                                    ->suffix(' % PV')
                                    ->size('lg'),

                                Infolists\Components\TextEntry::make('eficiencia_conversion')
                                    ->label('Eficiencia Conversión')
                                    ->numeric(
                                        decimalPlaces: 1,
                                        decimalSeparator: ',',
                                        thousandsSeparator: '.'
                                    )
                                    ->suffix(' kg MS/kg carne')
                                    ->size('lg'),
                            ]),
                    ]),
        ]);
    }


    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    
    public static function getPages(): array
    {
        return [
            'index' => ListModelos::route('/'),
            'create' => CreateModelo::route('/create'),
            'view' => ViewModelo::route('/{record}'),
            'edit' => EditModelo::route('/{record}/edit'),
        ];
    }
}
