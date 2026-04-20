<?php

namespace App\Models;

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
}