<?php

namespace App\Models;

use App\Models\Insumo;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Racion extends Model
{
    protected $fillable = [
        'nombre',
        'composicion',
        'insumos',
        'porcentajes',
    ];

    protected $casts = [
        'insumos' => 'array',
        'porcentajes' => 'array',
    ];

    protected function composicion(): Attribute
    {
        return Attribute::make(
            get: function ($value, array $attributes): array {
                $insumos = json_decode($attributes['insumos'] ?? '[]', true);
                $porcentajes = json_decode($attributes['porcentajes'] ?? '[]', true);
                $insumoIdsPorNombre = Insumo::query()->pluck('id', 'insumo')->all();

                if (! is_array($insumos)) {
                    $insumos = [];
                }

                if (! is_array($porcentajes)) {
                    $porcentajes = [];
                }

                $cantidadItems = max(count($insumos), count($porcentajes));
                $composicion = [];

                for ($indice = 0; $indice < $cantidadItems; $indice++) {
                    $insumo = $insumos[$indice] ?? null;

                    if (is_string($insumo) && ! ctype_digit($insumo)) {
                        $insumo = $insumoIdsPorNombre[$insumo] ?? null;
                    }

                    if (($insumos[$indice] ?? null) === null && ($porcentajes[$indice] ?? null) === null) {
                        continue;
                    }

                    $composicion[] = [
                        'insumo' => $insumo,
                        'porcentaje' => $porcentajes[$indice] ?? null,
                    ];
                }

                return $composicion;
            },
            set: function (?array $value): array {
                $insumos = [];
                $porcentajes = [];

                foreach ($value ?? [] as $item) {
                    $insumo = $item['insumo'] ?? null;
                    $porcentaje = $item['porcentaje'] ?? null;

                    if ($insumo === null && $porcentaje === null) {
                        continue;
                    }

                    $insumos[] = $insumo;
                    $porcentajes[] = $porcentaje === null ? null : (float) $porcentaje;
                }

                return [
                    'insumos' => json_encode($insumos, JSON_UNESCAPED_UNICODE),
                    'porcentajes' => json_encode($porcentajes, JSON_UNESCAPED_UNICODE),
                ];
            },
        );
    }

    protected function insumosTexto(): Attribute
    {
        return Attribute::make(
            get: function (): string {
                return collect($this->composicion_detallada)
                    ->pluck('nombre')
                    ->implode(', ');
            },
        );
    }

    protected function composicionTexto(): Attribute
    {
        return Attribute::make(
            get: function (): string {
                return collect($this->composicion_detallada)
                    ->map(static function (array $item): string {
                        $nombre = $item['nombre'] ?? '-';
                        $porcentaje = number_format((float) ($item['porcentaje'] ?? 0), 2, ',', '.');

                        return "{$nombre} ({$porcentaje}%)";
                    })
                    ->implode(', ');
            },
        );
    }

    protected function composicionDetallada(): Attribute
    {
        return Attribute::make(
            get: function (): array {
                $composicion = $this->composicion ?? [];
                $insumoIds = collect($composicion)
                    ->pluck('insumo')
                    ->filter(static fn ($id): bool => $id !== null && $id !== '')
                    ->map(static fn ($id): int => (int) $id)
                    ->unique()
                    ->values();

                $insumos = Insumo::query()
                    ->whereIn('id', $insumoIds)
                    ->get()
                    ->keyBy('id');

                return collect($composicion)
                    ->map(static function (array $item) use ($insumos): array {
                        $insumoId = isset($item['insumo']) ? (int) $item['insumo'] : null;
                        $insumo = $insumos->get($insumoId);

                        return [
                            'id' => $insumoId,
                            'nombre' => $insumo?->insumo ?? (string) ($item['insumo'] ?? ''),
                            'porcentaje' => (float) ($item['porcentaje'] ?? 0),
                            'porceMS' => (float) ($insumo?->porceMS ?? 0),
                            'precioTC' =>  ($insumo?->precio ?? 0),
                        ];
                    })
                    ->all();
            },
        );
    }

    protected function porcentajeMs(): Attribute
    {
        return Attribute::make(
            get: function (): float {
                $detalle = collect($this->composicion_detallada)
                    ->map(static function (array $item): array {
                        $aporteMs = ($item['porcentaje'] * $item['porceMS']) / 100;

                        return [
                            'insumo_id' => $item['id'] ?? null,
                            'insumo' => $item['nombre'] ?? null,
                            'porcentaje_en_racion' => (float) ($item['porcentaje'] ?? 0),
                            'porcentaje_ms_insumo' => (float) ($item['porceMS'] ?? 0),
                            'aporte_ms' => round($aporteMs, 4),
                        ];
                    })
                    ->all();

                $total = collect($detalle)
                    ->sum(static fn (array $item): float => (float) $item['aporte_ms']);

                Log::debug('Calculo de %MS de racion', [
                    'racion_id' => $this->getKey(),
                    'racion_nombre' => $this->nombre,
                    'detalle' => $detalle,
                    'total_ms_sin_redondear' => $total,
                    'total_ms_redondeado' => round($total, 2),
                    'calculo' => 'La suma de cada insumo se calcula multiplicando el porcentaje que representa en la ración por su porcentaje de materia seca, y luego dividiendo por 100. El total de %MS de la ración es la suma de los aportes de cada insumo.',
                ]);

                return round($total, 2);
            },
        );
    }

    protected function costoKgTc(): Attribute
    {
        return Attribute::make(
            get: function (): float {
                $detalle = collect($this->composicion_detallada)
                    ->map(static function (array $item): array {
                        $aporteCostoTc = ($item['porcentaje'] * $item['precioTC']) / 100;

                        return [
                            'insumo_id' => $item['id'] ?? null,
                            'insumo' => $item['nombre'] ?? null,
                            'porcentaje_en_racion' => (float) ($item['porcentaje'] ?? 0),
                            'precio_kg_tc_insumo' => (float) ($item['precioTC'] ?? 0),
                            'aporte_costo_tc' => round($aporteCostoTc, 4),
                        ];
                    })
                    ->all();

                $total = collect($detalle)
                    ->sum(static fn (array $item): float => (float) $item['aporte_costo_tc']);

                Log::debug('Calculo de $/Kg TC de racion', [
                    'racion_id' => $this->getKey(),
                    'racion_nombre' => $this->nombre,
                    'detalle' => $detalle,
                    'total_costo_tc_sin_redondear' => $total,
                    'total_costo_tc_redondeado' => round($total, 4),
                    'calculo' => 'La suma de cada insumo se calcula multiplicando el porcentaje que representa en la ración por su precio por kilo tal cual, y luego dividiendo por 100. El total de $/Kg TC de la ración es la suma de los aportes de cada insumo.',
                ]);

                return round($total, 4);
            },
        );
    }

    protected function costoKgMs(): Attribute
    {
        return Attribute::make(
            get: function (): float {
                $porcentajeMs = (float) $this->porcentaje_ms;

                if ($porcentajeMs <= 0) {
                    Log::debug('Calculo de $/Kg MS de racion', [
                        'racion_id' => $this->getKey(),
                        'racion_nombre' => $this->nombre,
                        'porcentaje_ms' => $porcentajeMs,
                        'costo_kg_tc' => (float) $this->costo_kg_tc,
                        'resultado' => 0,
                        'calculo' => 'No se puede calcular $/Kg MS porque el %MS de la ración es 0 o menor.',
                    ]);

                    return 0;
                }

                $costoKgTc = (float) $this->costo_kg_tc;
                $resultado = $costoKgTc / ($porcentajeMs / 100);

                Log::debug('Calculo de $/Kg MS de racion', [
                    'racion_id' => $this->getKey(),
                    'racion_nombre' => $this->nombre,
                    'costo_kg_tc' => $costoKgTc,
                    'porcentaje_ms' => $porcentajeMs,
                    'division_porcentaje_ms' => $porcentajeMs / 100,
                    'resultado_sin_redondear' => $resultado,
                    'resultado_redondeado' => round($resultado, 4),
                    'calculo' => 'El $/Kg MS se calcula dividiendo el costo por kilo tal cual de la ración por la fracción de materia seca (%MS / 100).',
                ]);

                return round($resultado, 4);
            },
        );
    }

    protected function totalPorcentajes(): Attribute
    {
        return Attribute::make(
            get: fn (): float => round(array_sum(array_map('floatval', $this->porcentajes ?? [])), 2),
        );
    }
}
