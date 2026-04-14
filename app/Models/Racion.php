<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Racion extends Model
{
    protected $fillable = [
        'nombre',
        'dieta_id',
        'insumo_id',
        'cantidad',
        'unidad_medida',
    ];

    protected $casts = [
        'cantidad' => 'decimal:2',
    ];

    public function dieta(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Dieta::class);
    }

    public function insumo(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Insumo::class);
    }
}
