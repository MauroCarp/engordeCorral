<?php

namespace App\Filament\Resources\SanidadEstructuras\Pages;

use App\Filament\Resources\SanidadEstructuras\SanidadEstructuraResource;
use App\Filament\Resources\SanidadEstructuras\Schemas\SanidadEstructuraForm;
use App\Filament\Resources\SanidadEstructuras\Widgets\EstructuraListWidget;
use App\Filament\Resources\SanidadEstructuras\Widgets\SanidadListWidget;
use App\Models\Modelo;
use App\Models\SanidadEstructura;
use App\Support\SanidadEstructuraBootstrapService;
use App\Support\SelectedModeloResolver;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Filament\Support\Exceptions\Halt;

class IndexSanidadEstructuras extends Page
{
    public ?int $selectedModeloId = null;

    protected static string $resource = SanidadEstructuraResource::class;

    public function mount(): void
    {
        $this->selectedModeloId = SelectedModeloResolver::resolveId();
    }

    public function updatedSelectedModeloId(?int $value): void
    {
        SelectedModeloResolver::set($value);
        $this->dispatch('refreshSanidadWidget');
        $this->dispatch('refreshEstructuraWidget');
    }

    public function getTitle(): string
    {
        $modelo = SelectedModeloResolver::resolve();

        if (! $modelo) {
            return 'Sanidad y Estructura';
        }

        return 'Sanidad y Estructura - ' . ($modelo->nombre ?? ('Modelo #' . $modelo->id));
    }

    /**
     * @return array<int, string>
     */
    public function getModeloOptionsProperty(): array
    {
        return Modelo::query()
            ->orderBy('nombre')
            ->pluck('nombre', 'id')
            ->toArray();
    }

    public function getView(): string
    {
        return 'filament.resources.sanidad-estructuras.pages.index-sanidad-estructuras';
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('syncMotivos')
                ->label('Sincronizar motivos')
                ->icon('heroicon-o-arrow-path')
                ->requiresConfirmation()
                ->modalHeading('Sincronizar motivos faltantes')
                ->modalDescription('Se agregarán registros de Sanidad y Estructura con costo 0 para los motivos que aún no existan en el modelo seleccionado. Los costos ya cargados no se modifican.')
                ->action(function (): void {
                    $modelo = SelectedModeloResolver::resolve();

                    if (! $modelo) {
                        Notification::make()
                            ->title('No hay modelos disponibles')
                            ->warning()
                            ->send();

                        return;
                    }

                    $created = app(SanidadEstructuraBootstrapService::class)
                        ->syncMissingMotivosForModelo($modelo);

                    Notification::make()
                        ->title($created > 0
                            ? "Se agregaron {$created} registros faltantes"
                            : 'No hay registros faltantes para sincronizar')
                        ->success()
                        ->send();

                    $this->dispatch('refreshSanidadWidget');
                    $this->dispatch('refreshEstructuraWidget');
                }),
            CreateAction::make()
                ->label('Nuevo Registro')
                ->modal()
                ->form(fn (\Filament\Schemas\Schema $schema) => SanidadEstructuraForm::configure($schema))
                ->successNotificationTitle('Registro guardado exitosamente')
                ->action(function (array $data): void {
                    $modeloId = SelectedModeloResolver::resolveId();

                    if (! $modeloId) {
                        Notification::make()
                            ->title('Seleccione un modelo')
                            ->warning()
                            ->send();

                        throw new Halt();
                    }

                    SanidadEstructura::query()->updateOrCreate(
                        [
                            'modelo_id' => $modeloId,
                            'tipo' => $data['tipo'],
                            'motivo' => $data['motivo'],
                        ],
                        [
                            'costo_mes' => $data['costo_mes'],
                        ],
                    );
                })
                ->after(function (): void {
                    $this->dispatch('refreshSanidadWidget');
                    $this->dispatch('refreshEstructuraWidget');
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
