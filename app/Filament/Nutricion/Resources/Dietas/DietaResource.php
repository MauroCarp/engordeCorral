<?php

namespace App\Filament\Nutricion\Resources\Dietas;

use App\Filament\Nutricion\Resources\Dietas\Pages\CreateDieta;
use App\Filament\Nutricion\Resources\Dietas\Pages\EditDieta;
use App\Filament\Nutricion\Resources\Dietas\Pages\ListDietas;
use App\Filament\Nutricion\Resources\Dietas\Schemas\DietaForm;
use App\Filament\Nutricion\Resources\Dietas\Tables\DietasTable;
use App\Models\Dieta;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DietaResource extends Resource
{
    protected static ?string $model = Dieta::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return DietaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DietasTable::configure($table);
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
            'index' => ListDietas::route('/'),
            'create' => CreateDieta::route('/create'),
            'edit' => EditDieta::route('/{record}/edit'),
        ];
    }
}
