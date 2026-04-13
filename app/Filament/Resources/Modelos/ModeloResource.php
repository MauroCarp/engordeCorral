<?php

namespace App\Filament\Resources\Modelos;

use App\Filament\Resources\Modelos\Pages\CreateModelo;
use App\Filament\Resources\Modelos\Pages\EditModelo;
use App\Filament\Resources\Modelos\Pages\ListModelos;
use App\Filament\Resources\Modelos\Schemas\ModeloForm;
use App\Filament\Resources\Modelos\Tables\ModelosTable;
use App\Models\Modelo;
use BackedEnum;
use Filament\Resources\Resource; 
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

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
            'edit' => EditModelo::route('/{record}/edit'),
        ];
    }
}
