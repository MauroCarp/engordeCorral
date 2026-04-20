<?php

namespace App\Filament\Resources\MotivoSanidadEstructuras;

use App\Filament\Resources\MotivoSanidadEstructuras\Pages\CreateMotivoSanidadEstructura;
use App\Filament\Resources\MotivoSanidadEstructuras\Pages\EditMotivoSanidadEstructura;
use App\Filament\Resources\MotivoSanidadEstructuras\Pages\ListMotivoSanidadEstructuras;
use App\Filament\Resources\MotivoSanidadEstructuras\Schemas\MotivoSanidadEstructuraForm;
use App\Filament\Resources\MotivoSanidadEstructuras\Tables\MotivoSanidadEstructurasTable;
use App\Models\MotivoSanidadEstructura;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class MotivoSanidadEstructuraResource extends Resource
{
    protected static ?string $model = MotivoSanidadEstructura::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-tag';

    protected static ?string $navigationLabel = 'Motivos';

    protected static ?string $modelLabel = 'Motivo';

    protected static ?string $pluralModelLabel = 'Motivos';

    // Oculto del menú de navegación
    protected static bool $shouldRegisterNavigation = false;

    public static function form(Schema $schema): Schema
    {
        return MotivoSanidadEstructuraForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MotivoSanidadEstructurasTable::configure($table);
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
            'index' => ListMotivoSanidadEstructuras::route('/'),
            'create' => CreateMotivoSanidadEstructura::route('/create'),
            'edit' => EditMotivoSanidadEstructura::route('/{record}/edit'),
        ];
    }
}