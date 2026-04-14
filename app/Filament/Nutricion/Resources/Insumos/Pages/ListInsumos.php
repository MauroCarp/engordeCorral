<?php

namespace App\Filament\Nutricion\Resources\Insumos\Pages;

use App\Filament\Nutricion\Resources\Insumos\InsumoResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListInsumos extends ListRecords
{
    protected static string $resource = InsumoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
