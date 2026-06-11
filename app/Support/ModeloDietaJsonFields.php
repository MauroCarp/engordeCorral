<?php

namespace App\Support;

class ModeloDietaJsonFields
{
    /**
     * @return array<int, array<string, mixed>>
     */
    public static function normalize(mixed $value): array
    {
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            $value = is_array($decoded) ? $decoded : [];
        }

        if (! is_array($value)) {
            return [];
        }

        return array_values(array_filter($value, static fn (mixed $item): bool => is_array($item)));
    }

    /**
     * @return array<int, array{racion_id:int|string|null, porcentaje:float|int|string|null}>
     */
    public static function normalizeForForm(mixed $value): array
    {
        return array_values(array_map(
            static fn (array $item): array => [
                'racion_id' => $item['racion_id'] ?? null,
                'porcentaje' => $item['porcentaje'] ?? null,
            ],
            self::normalize($value),
        ));
    }

    /**
     * @return array<int, array{racion_id:int, porcentaje:float}>
     */
    public static function normalizeForDatabase(mixed $value): array
    {
        return array_values(array_filter(
            array_map(static function (array $item): ?array {
                $racionId = $item['racion_id'] ?? null;
                $porcentaje = $item['porcentaje'] ?? null;

                if (! filled($racionId) || $porcentaje === null || $porcentaje === '') {
                    return null;
                }

                $porcentaje = (float) $porcentaje;

                if ($porcentaje <= 0) {
                    return null;
                }

                return [
                    'racion_id' => (int) $racionId,
                    'porcentaje' => $porcentaje,
                ];
            }, self::normalize($value)),
            static fn (?array $item): bool => $item !== null,
        ));
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    public static function mutateForForm(array $data): array
    {
        if (array_key_exists('dieta_json', $data)) {
            $data['dieta_json'] = self::normalizeForForm($data['dieta_json']);
        }

        return $data;
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    public static function mutateForDatabase(array $data): array
    {
        if (array_key_exists('dieta_json', $data)) {
            $data['dieta_json'] = self::normalizeForDatabase($data['dieta_json']);
        }

        return $data;
    }
}
