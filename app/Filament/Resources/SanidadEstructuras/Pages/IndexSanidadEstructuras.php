<?php

namespace App\Filament\Resources\SanidadEstructuras\Pages;

use App\Filament\Resources\SanidadEstructuras\SanidadEstructuraResource;
use App\Filament\Resources\SanidadEstructuras\Schemas\SanidadEstructuraForm;
use App\Filament\Resources\SanidadEstructuras\Widgets\EstructuraListWidget;
use App\Filament\Resources\SanidadEstructuras\Widgets\SanidadListWidget;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Pages\Page;

class IndexSanidadEstructuras extends Page
{
    protected static string $resource = SanidadEstructuraResource::class;

    public function getTitle(): string
    {
        return 'Sanidad y Estructura';
    }

    public function getView(): string
    {
        return 'filament.resources.sanidad-estructuras.pages.index-sanidad-estructuras';
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Nuevo Registro')
                ->modal()
                ->form(fn (\Filament\Schemas\Schema $schema) => SanidadEstructuraForm::configure($schema))
                ->successNotificationTitle('Registro creado exitosamente')
                ->after(function () {
                    $this->dispatch('$refresh');
                }),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [];
    }

    protected function getFooterWidgets(): array
    {
        return [
            SanidadListWidget::class,
            EstructuraListWidget::class,
        ];
    }
}