<?php

namespace App\Models;

use App\Support\SanidadEstructuraBootstrapService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MotivoSanidadEstructura extends Model
{
    use HasFactory;

    protected $table = 'motivo_sanidad_estructuras';

    protected $fillable = [
        'motivo',
        'tipo',
    ];

    protected static function booted(): void
    {
        static::created(function (MotivoSanidadEstructura $motivo): void {
            app(SanidadEstructuraBootstrapService::class)->syncMissingMotivosForAllModelos();
        });
    }
}