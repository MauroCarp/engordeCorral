<?php

namespace App\Filament\Resources\MotivoSanidadEstructuras\Pages;

use App\Filament\Resources\MotivoSanidadEstructuras\MotivoSanidadEstructuraResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMotivoSanidadEstructura extends EditRecord
{
    protected static string $resource = MotivoSanidadEstructuraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}