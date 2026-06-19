<?php

namespace App\Support;

use App\Models\Modelo;

class SelectedModeloResolver
{
    public const SESSION_KEY = 'selected_modelo_id';

    public static function resolveId(): ?int
    {
        $modeloId = session(self::SESSION_KEY);

        if ($modeloId) {
            return (int) $modeloId;
        }

        return Modelo::query()->latest()->first()?->id;
    }

    public static function resolve(): ?Modelo
    {
        $modeloId = self::resolveId();

        return $modeloId ? Modelo::find($modeloId) : null;
    }

    public static function set(?int $modeloId): void
    {
        if ($modeloId) {
            session([self::SESSION_KEY => $modeloId]);
        } else {
            session()->forget(self::SESSION_KEY);
        }
    }
}
