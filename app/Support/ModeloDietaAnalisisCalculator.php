<?php

namespace App\Support;

use App\Models\Modelo;
use App\Models\Racion;

class ModeloDietaAnalisisCalculator
{
    /**
     * @return array{modelo:?Modelo,rows:array<int, array<string, float|string>>,averages:array<string, float>,rowCount:int}
     */
    public function calculate(?Modelo $modelo): array
    {
        if (! $modelo) {
            return $this->emptyResult();
        }

        $pesoMedio = (((float) $modelo->peso_neto_entrada) + ((float) $modelo->peso_neto_venta)) / 2;
        $consumoPromedioMs = (float) $modelo->consumo_promedio_ms;
        $dieta = $this->normalizeDieta($modelo);

        $raciones = Racion::query()
            ->whereIn(
                'id',
                collect($dieta)
                    ->pluck('racion_id')
                    ->filter(static fn ($value): bool => filled($value))
                    ->map(static fn ($value): int => (int) $value)
                    ->unique()
                    ->values()
                    ->all(),
            )
            ->get()
            ->keyBy('id');

        $rows = collect($dieta)
            ->map(function (array $item) use ($raciones, $pesoMedio, $consumoPromedioMs): ?array {
                $racionId = (int) ($item['racion_id'] ?? 0);
                $participacion = ((float) ($item['porcentaje'] ?? 0)) / 100;
                /** @var ?Racion $racion */
                $racion = $raciones->get($racionId);

                if (! $racion || $participacion <= 0) {
                    return null;
                }

                $porcentajeMs = (float) $racion->porcentaje_ms;
                $porcentajeMsFactor = $porcentajeMs / 100;
                $consumoMfFactor = $this->safeDivide($consumoPromedioMs * $participacion, $porcentajeMsFactor);
                $consumoTc = $consumoMfFactor * $pesoMedio;
                $consumoMs = $consumoTc * $porcentajeMsFactor;
                $costoKgTc = (float) $racion->costo_kg_tc;
                $costoKgMs = (float) $racion->costo_kg_ms;

                return [
                    'dieta' => (string) $racion->nombre,
                    'participacion' => $participacion,
                    'peso_medio' => $pesoMedio,
                    'cons_mf' => $consumoMfFactor * 100,
                    'consumo_tc' => $consumoTc,
                    'porcentaje_ms' => $porcentajeMs,
                    'consumo_ms' => $consumoMs,
                    'costo_kg_tc' => $costoKgTc,
                    'costo_kg_ms' => $costoKgMs,
                    'costo_kg_ms_cab_dia' => round($costoKgMs * $consumoMs),
                ];
            })
            ->filter()
            ->values();

        return [
            'modelo' => $modelo,
            'rows' => $rows->all(),
            'averages' => [
                'peso_medio' => $this->weightedAverage($rows, 'peso_medio'),
                'cons_mf' => $this->weightedAverage($rows, 'cons_mf'),
                'consumo_tc' => $this->weightedAverage($rows, 'consumo_tc'),
                'porcentaje_ms' => $this->weightedAverage($rows, 'porcentaje_ms'),
                'consumo_ms' => $this->weightedAverage($rows, 'consumo_ms'),
                'costo_kg_tc' => $this->weightedAverage($rows, 'costo_kg_tc'),
                'costo_kg_ms' => $this->weightedAverage($rows, 'costo_kg_ms'),
                'costo_kg_ms_cab_dia' => $this->weightedAverage($rows, 'costo_kg_ms_cab_dia'),
            ],
            'rowCount' => $rows->count(),
        ];
    }

    /**
     * @return array<int, array{racion_id:int|string|null, porcentaje:float|int|string|null}>
     */
    private function normalizeDieta(Modelo $modelo): array
    {
        $dieta = $modelo->dieta;

        if (is_string($dieta)) {
            $decoded = json_decode($dieta, true);
            $dieta = is_array($decoded) ? $decoded : [];
        }

        if (! is_array($dieta) && array_key_exists('dieta_json', $modelo->getAttributes())) {
            $decoded = json_decode((string) $modelo->getAttribute('dieta_json'), true);
            $dieta = is_array($decoded) ? $decoded : [];
        }

        return is_array($dieta) ? $dieta : [];
    }

    /**
     * @param  \Illuminate\Support\Collection<int, array<string, float|string>>  $rows
     */
    private function weightedAverage($rows, string $column): float
    {
        if ($rows->isEmpty()) {
            return 0.0;
        }

        $totalWeight = (float) $rows->sum(static fn (array $row): float => (float) ($row['participacion'] ?? 0));

        if ($totalWeight <= 0) {
            return 0.0;
        }

        $weightedTotal = (float) $rows->sum(static function (array $row) use ($column): float {
            return ((float) ($row[$column] ?? 0)) * ((float) ($row['participacion'] ?? 0));
        });

        return $weightedTotal / $totalWeight;
    }

    /**
     * @return array{modelo:?Modelo,rows:array<int, array<string, float|string>>,averages:array<string, float>,rowCount:int}
     */
    private function emptyResult(): array
    {
        return [
            'modelo' => null,
            'rows' => [],
            'averages' => [
                'peso_medio' => 0.0,
                'cons_mf' => 0.0,
                'consumo_tc' => 0.0,
                'porcentaje_ms' => 0.0,
                'consumo_ms' => 0.0,
                'costo_kg_tc' => 0.0,
                'costo_kg_ms' => 0.0,
                'costo_kg_ms_cab_dia' => 0.0,
            ],
            'rowCount' => 0,
        ];
    }

    private function safeDivide(float $value, float $divisor): float
    {
        if ($divisor == 0.0) {
            return 0.0;
        }

        return $value / $divisor;
    }
}