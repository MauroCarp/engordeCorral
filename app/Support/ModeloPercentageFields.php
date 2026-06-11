<?php

namespace App\Support;

class ModeloPercentageFields
{
    /**
     * Campos almacenados como fracción en BD (0.25 = 25%) y mostrados como % en el formulario.
     *
     * @var list<string>
     */
    public const FIELDS = [
        'tasa_anual',
        'gastos_compra',
        'gastos_venta',
        'mortandad',
        'consumo_promedio_ms',
    ];

    public static function toDisplay(mixed $value): ?float
    {
        if ($value === null || $value === '') {
            return null;
        }

        return (float) $value * 100;
    }

    public static function toStorage(mixed $value): ?float
    {
        if ($value === null || $value === '') {
            return null;
        }

        return (float) $value / 100;
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    public static function mutateForForm(array $data): array
    {
        foreach (self::FIELDS as $field) {
            if (array_key_exists($field, $data)) {
                $data[$field] = self::toDisplay($data[$field]);
            }
        }

        return $data;
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    public static function mutateForDatabase(array $data): array
    {
        foreach (self::FIELDS as $field) {
            if (array_key_exists($field, $data)) {
                $data[$field] = self::toStorage($data[$field]);
            }
        }

        return $data;
    }
}
