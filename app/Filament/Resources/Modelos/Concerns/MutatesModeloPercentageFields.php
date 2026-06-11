<?php

namespace App\Filament\Resources\Modelos\Concerns;

use App\Support\ModeloPercentageFields;

trait MutatesModeloPercentageFields
{
    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutatePercentageFieldsForForm(array $data): array
    {
        return ModeloPercentageFields::mutateForForm($data);
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutatePercentageFieldsForDatabase(array $data): array
    {
        return ModeloPercentageFields::mutateForDatabase($data);
    }
}
