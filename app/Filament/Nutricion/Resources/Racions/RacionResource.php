<?php

namespace App\Filament\Nutricion\Resources\Racions;

use App\Filament\Nutricion\Resources\Racions\Pages\CreateRacion;
use App\Filament\Nutricion\Resources\Racions\Pages\EditRacion;
use App\Filament\Nutricion\Resources\Racions\Pages\ListRacions;
use App\Filament\Nutricion\Resources\Racions\Schemas\RacionForm;
use App\Filament\Nutricion\Resources\Racions\Tables\RacionsTable;
use App\Models\Racion;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class RacionResource extends Resource
{
    protected static ?string $model = Racion::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $navigationLabel = 'Raciones';

    protected static ?string $modelLabel = 'Ración';

    protected static ?string $pluralModelLabel = 'Raciones';

    public static function form(Schema $schema): Schema
    {
        return RacionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RacionsTable::configure($table);
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
            'index' => ListRacions::route('/'),
            'create' => CreateRacion::route('/create'),
            'edit' => EditRacion::route('/{record}/edit'),
        ];
    }
}
