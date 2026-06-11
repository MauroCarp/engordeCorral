<?php

namespace App\Filament\Resources\Modelos\Pages;

use App\Filament\Resources\Modelos\Concerns\MutatesModeloDietaJson;
use App\Filament\Resources\Modelos\Concerns\MutatesModeloPercentageFields;
use App\Filament\Resources\Modelos\ModeloResource;
use Filament\Resources\Pages\CreateRecord;

class CreateModelo extends CreateRecord
{
    use MutatesModeloDietaJson;
    use MutatesModeloPercentageFields;

    protected static string $resource = ModeloResource::class;

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return $this->mutateDietaJsonForDatabase(
            $this->mutatePercentageFieldsForDatabase($data),
        );
    }
}
