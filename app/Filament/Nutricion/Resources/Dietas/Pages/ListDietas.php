<?php

namespace App\Filament\Nutricion\Resources\Dietas\Pages;

use App\Filament\Nutricion\Resources\Dietas\DietaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDietas extends ListRecords
{
    protected static string $resource = DietaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
