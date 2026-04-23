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
                    ->columns(3)
                    ->schema([
                        Infolists\Components\TextEntry::make('precio_venta_faena')
                            ->label('Precio venta a faena ($/kg)')
                            ->numeric(
                                decimalPlaces: 1,
                                decimalSeparator: ',',
                                thousandsSeparator: '.'
                            ),

                        Infolists\Components\TextEntry::make('precio_compra_ternero')
                            ->label('Precio compra terneras/os destete ($/kg)')
                            ->numeric(
                                decimalPlaces: 1,
                                decimalSeparator: ',',
                                thousandsSeparator: '.'
                            ),

                        Infolists\Components\TextEntry::make('peso_neto_entrada')
                            ->label('Peso neto de entrada (kg)')
                            ->numeric(
                                decimalPlaces: 2,
                                decimalSeparator: ',',
                                thousandsSeparator: '.'
                            ),

                        Infolists\Components\TextEntry::make('peso_neto_venta')
                            ->label('Peso neto venta (kg)')
                            ->numeric(
                                decimalPlaces: 2,
                                decimalSeparator: ',',
                                thousandsSeparator: '.'
                            ),
                    ]),

                ComponentsSection::make('Financiero')
                    ->columns(3)
                    ->schema([
                        Infolists\Components\TextEntry::make('tasa_anual')
                            ->label('Tasa anual (%)')
                            ->numeric(
                                decimalPlaces: 0,
                                decimalSeparator: ',',
                                thousandsSeparator: '.'
                            ),

                        Infolists\Components\TextEntry::make('plazo_compra_hacienda')
                            ->label('Plazo compra hacienda (días)')
                            ->numeric(
                                decimalPlaces: 0
                            ),

                        Infolists\Components\TextEntry::make('plazo_venta_hacienda')
                            ->label('Plazo venta hacienda (días)')
                            ->numeric(
                                decimalPlaces: 0
                            ),

                        Infolists\Components\TextEntry::make('dias_financiamiento_alimento')
                            ->label('Días de financiamiento alimento')
                            ->numeric(
                                decimalPlaces: 0
                            ),
                    ]),

                ComponentsSection::make('Comercialización')
                    ->columns(2)
                    ->schema([
                        Infolists\Components\TextEntry::make('cabezas_jaula_terneros')
                            ->label('Cabezas/jaula (Terneros/as)')
                            ->numeric(
                                decimalPlaces: 0
                            ),

                        Infolists\Components\TextEntry::make('cabezas_jaula_gordos')
                            ->label('Cabezas/jaula (Gordos/as)')
                            ->numeric(
                                decimalPlaces: 0
                            ),

                        Infolists\Components\TextEntry::make('flete_compra_km')
                            ->label('Flete compra (km)')
                            ->numeric(
                                decimalPlaces: 0,
                                decimalSeparator: ',',
                                thousandsSeparator: '.'
                            ),

                        Infolists\Components\TextEntry::make('flete_venta_km')
                            ->label('Flete venta (km)')
                            ->numeric(
                                decimalPlaces: 0,
                                decimalSeparator: ',',
                                thousandsSeparator: '.'
                            ),

                        Infolists\Components\TextEntry::make('flete_compra_venta_precio')
                            ->label('Flete compra-venta - precio ($/km)')
                            ->numeric(
                                decimalPlaces: 0,
                                decimalSeparator: ',',
                                thousandsSeparator: '.'
                            ),

                        Infolists\Components\TextEntry::make('gastos_compra')
                            ->label('Gastos de compra (%)')
                            ->numeric(
                                decimalPlaces: 0,
                                decimalSeparator: ',',
                                thousandsSeparator: '.'
                            ),

                        Infolists\Components\TextEntry::make('gastos_venta')
                            ->label('Gastos de venta (%)')
                            ->numeric(
                                decimalPlaces: 0,
                                decimalSeparator: ',',
                                thousandsSeparator: '.'
                            ),
                    ]),

                ComponentsSection::make('')
                    ->columns(1)
                    ->schema([
                        ComponentsSection::make('Sanidad')
                            ->schema([
                                Infolists\Components\TextEntry::make('mortandad')
                                    ->label('Mortandad (1%)')
                                    ->numeric(
                                        decimalPlaces: 1,
                                        decimalSeparator: ',',
                                        thousandsSeparator: '.'
                                    ),
                            ]),

                        ComponentsSection::make('Nutrición')
                            ->columns(3)
                            ->schema([
                                Infolists\Components\TextEntry::make('precio_alimento_balanceado')
                                    ->label('Precio tal cual alimento balanceado ($/kg)')
                                    ->numeric(
                                        decimalPlaces: 1,
                                        decimalSeparator: ',',
                                        thousandsSeparator: '.'
                                    ),

                                Infolists\Components\TextEntry::make('consumo_promedio_ms')
                                    ->label('Consumo promedio MS en terminación (% PV)')
                                    ->numeric(
                                        decimalPlaces: 1,
                                        decimalSeparator: ',',
                                        thousandsSeparator: '.'
                                    ),

                                Infolists\Components\TextEntry::make('eficiencia_conversion')
                                    ->label('Eficiencia conversión (kg MS/kg carne)')
                                    ->numeric(
                                        decimalPlaces: 1,
                                        decimalSeparator: ',',
                                        thousandsSeparator: '.'
                                    ),
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
