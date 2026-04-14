<?php

namespace App\Filament\Nutricion\Resources\Insumos\Pages;

use App\Filament\Nutricion\Resources\Insumos\InsumoResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditInsumo extends EditRecord
{
    protected static string $resource = InsumoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
