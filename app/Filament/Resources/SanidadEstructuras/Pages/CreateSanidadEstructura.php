<?php

namespace App\Filament\Resources\SanidadEstructuras\Pages;

use App\Filament\Resources\SanidadEstructuras\SanidadEstructuraResource;
use App\Support\SelectedModeloResolver;
use Filament\Resources\Pages\CreateRecord;

class CreateSanidadEstructura extends CreateRecord
{
    protected static string $resource = SanidadEstructuraResource::class;

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['modelo_id'] = SelectedModeloResolver::resolveId();

        return $data;
    }
}
