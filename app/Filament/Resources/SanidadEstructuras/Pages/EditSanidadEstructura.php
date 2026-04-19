<?php

namespace App\Filament\Resources\SanidadEstructuras\Pages;

use App\Filament\Resources\SanidadEstructuras\SanidadEstructuraResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSanidadEstructura extends EditRecord
{
    protected static string $resource = SanidadEstructuraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}