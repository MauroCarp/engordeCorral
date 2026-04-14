<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dieta extends Model
{
    protected $fillable = [
        'nombre',
        'descripcion',
        'observaciones',
    ];

    public function raciones(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Racion::class);
    }
}
