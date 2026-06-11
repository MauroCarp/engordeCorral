<?php

namespace App\Filament\Resources\Modelos\Pages;

use App\Filament\Resources\Modelos\Concerns\MutatesModeloDietaJson;
use App\Filament\Resources\Modelos\Concerns\MutatesModeloPercentageFields;
use App\Filament\Resources\Modelos\ModeloResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditModelo extends EditRecord
{
    use MutatesModeloDietaJson;
    use MutatesModeloPercentageFields;

    protected static string $resource = ModeloResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeFill(array $data): array
    {
        return $this->mutateDietaJsonForForm(
            $this->mutatePercentageFieldsForForm($data),
        );
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        return $this->mutateDietaJsonForDatabase(
            $this->mutatePercentageFieldsForDatabase($data),
        );
    }
}
