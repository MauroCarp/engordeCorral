<?php

namespace App\Filament\Nutricion\Resources\Racions\Pages;

use App\Filament\Nutricion\Resources\Racions\RacionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditRacion extends EditRecord
{
    protected static string $resource = RacionResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['composicion'] = $this->record->composicion;

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
