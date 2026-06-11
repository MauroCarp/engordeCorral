<?php

namespace App\Filament\Resources\Modelos\Concerns;

use App\Support\ModeloDietaJsonFields;

trait MutatesModeloDietaJson
{
    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateDietaJsonForForm(array $data): array
    {
        return ModeloDietaJsonFields::mutateForForm($data);
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateDietaJsonForDatabase(array $data): array
    {
        return ModeloDietaJsonFields::mutateForDatabase($data);
    }
}
