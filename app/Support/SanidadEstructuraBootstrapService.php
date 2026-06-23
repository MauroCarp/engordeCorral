<?php

namespace App\Support;

use App\Models\Modelo;
use App\Models\MotivoSanidadEstructura;
use App\Models\SanidadEstructura;

class SanidadEstructuraBootstrapService
{
    public function bootstrapForModelo(Modelo $modelo): int
    {
        return $this->syncMissingMotivosForModelo($modelo);
    }

    public function syncMissingMotivosForModelo(Modelo $modelo): int
    {
        $created = 0;

        MotivoSanidadEstructura::query()
            ->orderBy('id')
            ->each(function (MotivoSanidadEstructura $motivo) use ($modelo, &$created): void {
                $exists = SanidadEstructura::query()
                    ->where('modelo_id', $modelo->id)
                    ->where('tipo', $motivo->tipo)
                    ->where('motivo', $motivo->motivo)
                    ->exists();

                if ($exists) {
                    return;
                }

                SanidadEstructura::query()->create([
                    'modelo_id' => $modelo->id,
                    'tipo' => $motivo->tipo,
                    'motivo' => $motivo->motivo,
                    'costo_mes' => 0,
                ]);

                $created++;
            });

        return $created;
    }

    public function syncMissingMotivosForAllModelos(): int
    {
        $created = 0;

        Modelo::query()
            ->orderBy('id')
            ->each(function (Modelo $modelo) use (&$created): void {
                $created += $this->syncMissingMotivosForModelo($modelo);
            });

        return $created;
    }

    public function backfillOrphanRecords(): int
    {
        $orphanCount = SanidadEstructura::query()->whereNull('modelo_id')->count();

        if ($orphanCount === 0) {
            return 0;
        }

        if (Modelo::query()->count() !== 1) {
            return 0;
        }

        $modeloId = Modelo::query()->value('id');

        return SanidadEstructura::query()
            ->whereNull('modelo_id')
            ->update(['modelo_id' => $modeloId]);
    }
}
