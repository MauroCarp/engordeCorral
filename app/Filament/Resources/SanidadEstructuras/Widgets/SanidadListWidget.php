<?php

namespace App\Filament\Resources\SanidadEstructuras\Widgets;

use App\Filament\Resources\SanidadEstructuras\Support\SanidadEstructuraTableActions;
use App\Models\SanidadEstructura;
use App\Support\SelectedModeloResolver;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class SanidadListWidget extends BaseWidget
{
    protected static ?string $heading = 'Registros de Sanidad';

    protected int | string | array $columnSpan = 'half';

    protected string | array $poll = '30s';

    protected $listeners = [
        '$refresh' => 'refreshWidget',
        'refreshSanidadWidget' => 'refreshWidget',
    ];

    public function refreshWidget(): void
    {
        $this->dispatch('$refresh');
    }

    public function table(Table $table): Table
    {
        $modeloId = SelectedModeloResolver::resolveId();

        return $table
            ->query(
                SanidadEstructura::query()
                    ->where('tipo', 'sanidad')
                    ->when($modeloId, fn ($query) => $query->where('modelo_id', $modeloId))
                    ->when(! $modeloId, fn ($query) => $query->whereRaw('1 = 0')),
            )
            ->columns([
                TextColumn::make('motivo')
                    ->label('Motivo')
                    ->limit(50)
                    ->searchable(),

                TextColumn::make('costo_mes')
                    ->label('$/Cab')
                    ->sortable()
                    ->prefix('$')
                    ->numeric(decimalPlaces: 0, decimalSeparator: ',', thousandsSeparator: '.')
                    ->summarize([
                        \Filament\Tables\Columns\Summarizers\Sum::make()
                            ->prefix('$')
                            ->numeric(decimalPlaces: 0, decimalSeparator: ',', thousandsSeparator: '.')
                            ->label('Total $/Cab'),
                    ]),
            ])
            ->actions([
                SanidadEstructuraTableActions::editCostoAction(
                    'Editar costo de Sanidad',
                    fn () => $this->refreshWidget(),
                ),
                DeleteAction::make()
                    ->requiresConfirmation()
                    ->modalHeading('Eliminar Registro de Sanidad')
                    ->modalDescription('¿Estás seguro de que deseas eliminar este registro? Esta acción no se puede deshacer.')
                    ->modalSubmitActionLabel('Eliminar')
                    ->successNotificationTitle('Registro eliminado exitosamente')
                    ->after(fn () => $this->refreshWidget()),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->requiresConfirmation()
                        ->modalHeading('Eliminar Registros de Sanidad')
                        ->modalDescription('¿Estás seguro de que deseas eliminar los registros seleccionados? Esta acción no se puede deshacer.')
                        ->modalSubmitActionLabel('Eliminar Seleccionados')
                        ->successNotificationTitle('Registros eliminados exitosamente')
                        ->after(fn () => $this->refreshWidget()),
                ]),
            ])
            ->emptyStateHeading('No hay registros de Sanidad')
            ->emptyStateDescription('Seleccione un modelo y sincronice motivos o cree un registro desde "Nuevo Registro".')
            ->paginated(false)
            ->searchable(false);
    }
}
