<?php

namespace App\Filament\Nutricion\Resources\Dietas\Pages;

use App\Filament\Nutricion\Resources\Dietas\DietaResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditDieta extends EditRecord
{
    protected static string $resource = DietaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
