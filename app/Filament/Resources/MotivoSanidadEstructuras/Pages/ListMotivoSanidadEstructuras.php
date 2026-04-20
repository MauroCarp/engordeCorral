<?php

namespace App\Filament\Resources\MotivoSanidadEstructuras\Pages;

use App\Filament\Resources\MotivoSanidadEstructuras\MotivoSanidadEstructuraResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMotivoSanidadEstructuras extends ListRecords
{
    protected static string $resource = MotivoSanidadEstructuraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}