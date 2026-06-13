<?php

namespace App\Filament\Resources\SanidadEstructuras\Widgets;

use App\Models\SanidadEstructura;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Support\Facades\FilamentView;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class SanidadListWidget extends BaseWidget
{
    protected static ?string $heading = 'Registros de Sanidad';

    protected int | string | array $columnSpan = 'half';

    // Polling automático cada 30 segundos
    protected string | array $poll = '30s';

    // Listeners para eventos de refresh
    protected $listeners = [
        '$refresh' => 'refreshWidget',
        'refreshSanidadWidget' => 'refreshWidget',
    ];

    public function refreshWidget()
    {
        $this->dispatch('$refresh');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(SanidadEstructura::query()->where('tipo', 'sanidad'))
            ->columns([
                TextColumn::make('motivo')
                    ->label('Motivo')
                    ->limit(50)
                    ->searchable(),

                TextColumn::make('costo_mes')
                    ->label('$/Cab')
                    // ->money('ARS',false,false,0)
                    ->sortable()
                    ->prefix('$')
                    ->numeric(decimalPlaces: 1, decimalSeparator: ',', thousandsSeparator: '.')
                    ->summarize([
                        \Filament\Tables\Columns\Summarizers\Sum::make()
                            // ->money('ARS',false,false,0)
                            ->prefix('$')
                            ->numeric(decimalPlaces: 1, decimalSeparator: ',', thousandsSeparator: '.')
                            ->label('Total $/Cab'),
                    ]),
            ])
            ->actions([
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
            ->emptyStateDescription('Crea el primer registro de sanidad desde el botón "Nuevo Registro".')
            ->paginated(false)
            ->searchable(false);
    }
}