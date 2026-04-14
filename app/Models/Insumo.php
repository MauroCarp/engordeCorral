<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Insumo extends Model
{
    protected $fillable = [
        'nombre',
        'descripcion',
        'unidad_medida',
        'precio_por_unidad',
        'stock',
    ];

    protected $casts = [
        'precio_por_unidad' => 'decimal:2',
        'stock'             => 'decimal:2',
    ];
}
