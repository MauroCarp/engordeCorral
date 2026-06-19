<?php

namespace App\Filament\Resources\SanidadEstructuras\Widgets;

use App\Models\SanidadEstructura;
use App\Support\SelectedModeloResolver;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class EstructuraListWidget extends BaseWidget
{
    protected static ?string $heading = null;

    protected int | string | array $columnSpan = 'half';

    protected string | array $poll = '30s';

    protected $listeners = [
        '$refresh' => 'refreshWidget',
        'refreshEstructuraWidget' => 'refreshWidget',
    ];

    public function refreshWidget(): void
    {
        $this->dispatch('$refresh');
    }

    protected function getTableHeading(): string | \Illuminate\Contracts\Support\Htmlable | null
    {
        $modelo = SelectedModeloResolver::resolve();

        if (! $modelo) {
            return 'Registros de Estructura';
        }

        $capacidad = $modelo->capacidad_estructura;

        if ($capacidad === null || $capacidad === '') {
            return 'Registros de Estructura';
        }

        return 'Registros de Estructura | Capacidad: ' . $capacidad;
    }

    public function table(Table $table): Table
    {
        $modeloId = SelectedModeloResolver::resolveId();

        return $table
            ->query(
                SanidadEstructura::query()
                    ->where('tipo', 'estructura')
                    ->when($modeloId, fn ($query) => $query->where('modelo_id', $modeloId))
                    ->when(! $modeloId, fn ($query) => $query->whereRaw('1 = 0')),
            )
            ->columns([
                TextColumn::make('motivo')
                    ->label('Motivo')
                    ->limit(50)
                    ->searchable(),

                TextColumn::make('costo_mes')
                    ->label('Costo por Mes')
                    ->prefix('$')
                    ->numeric(decimalPlaces: 0, decimalSeparator: ',', thousandsSeparator: '.')
                    ->sortable()
                    ->summarize([
                        \Filament\Tables\Columns\Summarizers\Sum::make()
                            ->prefix('$')
                            ->numeric(decimalPlaces: 0, decimalSeparator: ',', thousandsSeparator: '.')
                            ->label('Total $/Mes'),
                    ]),
            ])
            ->actions([
                DeleteAction::make()
                    ->requiresConfirmation()
                    ->modalHeading('Eliminar Registro de Estructura')
                    ->modalDescription('¿Estás seguro de que deseas eliminar este registro? Esta acción no se puede deshacer.')
                    ->modalSubmitActionLabel('Eliminar')
                    ->successNotificationTitle('Registro eliminado exitosamente')
                    ->after(fn () => $this->refreshWidget()),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->requiresConfirmation()
                        ->modalHeading('Eliminar Registros de Estructura')
                        ->modalDescription('¿Estás seguro de que deseas eliminar los registros seleccionados? Esta acción no se puede deshacer.')
                        ->modalSubmitActionLabel('Eliminar Seleccionados')
                        ->successNotificationTitle('Registros eliminados exitosamente')
                        ->after(fn () => $this->refreshWidget()),
                ]),
            ])
            ->emptyStateHeading('No hay registros de Estructura')
            ->emptyStateDescription('Seleccione un modelo y sincronice motivos o cree un registro desde "Nuevo Registro".')
            ->paginated(false)
            ->searchable(false);
    }
}
