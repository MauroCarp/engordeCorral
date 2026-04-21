<?php

namespace App\Filament\Nutricion\Resources\Insumos;

use App\Filament\Nutricion\Resources\Insumos\Pages\CreateInsumo;
use App\Filament\Nutricion\Resources\Insumos\Pages\EditInsumo;
use App\Filament\Nutricion\Resources\Insumos\Pages\ListInsumos;
use App\Filament\Nutricion\Resources\Insumos\Schemas\InsumoForm;
use App\Filament\Nutricion\Resources\Insumos\Tables\InsumosTable;
use App\Models\Insumo;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class InsumoResource extends Resource
{
    protected static ?string $model = Insumo::class;

    protected static bool $shouldRegisterNavigation = false;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'insumo';

    public static function form(Schema $schema): Schema
    {
        return InsumoForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InsumosTable::configure($table);
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
            'index' => ListInsumos::route('/'),
            'create' => CreateInsumo::route('/create'),
            'edit' => EditInsumo::route('/{record}/edit'),
        ];
    }
}
