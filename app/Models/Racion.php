<?php

namespace App\Models;

use App\Models\Insumo;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

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
                $insumos = $this->insumos ?? [];
                $insumosPorId = Insumo::query()->pluck('insumo', 'id')->all();

                return implode(', ', array_map(
                    static fn ($insumo): string => $insumosPorId[$insumo] ?? (string) $insumo,
                    $insumos,
                ));
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
