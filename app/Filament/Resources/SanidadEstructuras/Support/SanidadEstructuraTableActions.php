<?php

namespace App\Filament\Resources\SanidadEstructuras\Support;

use App\Filament\Resources\SanidadEstructuras\Schemas\SanidadEstructuraForm;
use Filament\Actions\EditAction;
use Filament\Schemas\Schema;

class SanidadEstructuraTableActions
{
    public static function editCostoAction(string $modalHeading, callable $after): EditAction
    {
        return EditAction::make()
            ->modalHeading($modalHeading)
            ->form(fn (Schema $schema) => SanidadEstructuraForm::configureCostoEdit($schema))
            ->successNotificationTitle('Costo actualizado exitosamente')
            ->after($after);
    }
}
