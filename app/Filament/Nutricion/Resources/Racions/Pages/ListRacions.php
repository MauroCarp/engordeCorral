<?php

namespace App\Filament\Nutricion\Resources\Racions\Pages;

use App\Filament\Nutricion\Resources\Racions\RacionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRacions extends ListRecords
{
    protected static string $resource = RacionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
