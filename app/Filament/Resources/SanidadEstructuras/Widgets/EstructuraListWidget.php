<?php

namespace App\Filament\Resources\SanidadEstructuras\Widgets;

use App\Models\SanidadEstructura;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class EstructuraListWidget extends BaseWidget
{
    protected static ?string $heading = 'Registros de Estructura';

    protected int | string | array $columnSpan = 'half';

    // Polling automático cada 30 segundos
    protected string | array $poll = '30s';

    // Listeners para eventos de refresh
    protected $listeners = [
        '$refresh' => 'refreshWidget',
        'refreshEstructuraWidget' => 'refreshWidget',
    ];

    public function refreshWidget()
    {
        $this->dispatch('$refresh');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(SanidadEstructura::query()->where(['tipo' => 'estructura']))
            ->columns([
                TextColumn::make('motivo')
                    ->label('Motivo')
                    ->limit(50)
                    ->searchable(),

                TextColumn::make('costo_mes')
                    ->label('Costo por Mes')
                    ->money('ARS',false,false,0)
                    ->sortable()
                    ->summarize([
                        \Filament\Tables\Columns\Summarizers\Sum::make()
                            ->money('ARS',false,false,0)
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
            ->emptyStateDescription('Crea el primer registro de estructura desde el botón "Nuevo Registro".')
            ->paginated(false)
            ->searchable(false);
    }
}