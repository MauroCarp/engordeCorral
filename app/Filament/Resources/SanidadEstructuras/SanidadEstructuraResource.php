<?php

namespace App\Filament\Resources\SanidadEstructuras;

use App\Filament\Resources\SanidadEstructuras\Pages\CreateSanidadEstructura;
use App\Filament\Resources\SanidadEstructuras\Pages\EditSanidadEstructura;
use App\Filament\Resources\SanidadEstructuras\Pages\IndexSanidadEstructuras;
use App\Filament\Resources\SanidadEstructuras\Pages\ListSanidadEstructuras;
use App\Filament\Resources\SanidadEstructuras\Schemas\SanidadEstructuraForm;
use App\Filament\Resources\SanidadEstructuras\Tables\SanidadEstructurasTable;
use App\Models\SanidadEstructura;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class SanidadEstructuraResource extends Resource
{
    protected static ?string $model = SanidadEstructura::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-shield-check';

    protected static ?string $navigationLabel = 'Sanidad Estructura';

    protected static ?string $modelLabel = 'Sanidad Estructura';

    protected static ?string $pluralModelLabel = 'Sanidad Estructuras';

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Schema $schema): Schema
    {
        return SanidadEstructuraForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SanidadEstructurasTable::configure($table);
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
            'index' => IndexSanidadEstructuras::route('/'),
            'list' => ListSanidadEstructuras::route('/list'),
            'create' => CreateSanidadEstructura::route('/create'),
            'edit' => EditSanidadEstructura::route('/{record}/edit'),
        ];
    }
}