<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SanidadEstructura extends Model
{
    use HasFactory;

    protected $table = 'sanidad_estructuras';

    protected $fillable = [
        'tipo',
        'motivo',
        'costo_mes',
    ];

    protected $casts = [
        'costo_mes' => 'decimal:2',
    ];
}