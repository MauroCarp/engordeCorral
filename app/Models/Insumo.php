<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Insumo extends Model
{
    protected $fillable = [
        'insumo',
        'tipo', 
        'precio',
        'porceMS',
        'DMS',
        'EE',
        'Pr',
        'PBa',
        'PBb',
        'H',
        'NIDA',
        'EM',
    ];

    protected $casts = [
        'precio' => 'float',
        'porceMS' => 'float',
        'DMS' => 'float',
        'EE' => 'float',
        'Pr' => 'float',
        'PBa' => 'float',
        'PBb' => 'float',
        'H' => 'float',
        'NIDA' => 'float',
        'EM' => 'float',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    
    /**
     * Get the formatted price with currency
     */
    public function getFormattedPriceAttribute(): string
    {
        return '$' . number_format($this->precio, 2, ',', '.');
    }
    
    /**
     * Get nutritional values as array
     */
    public function getNutritionalValues(): array
    {
        return [
            'Materia Seca (%)' => $this->porceMS,
            'Digestibilidad MS (%)' => $this->DMS,
            'Extracto Etéreo (%)' => $this->EE,
            'Proteína (%)' => $this->Pr,
            'Proteína Degradable (%)' => $this->PBa,
            'Proteína No Degradable (%)' => $this->PBb,
            'Hidratos (%)' => $this->H,
            'NIDA (%)' => $this->NIDA,
            'Energía Metabolizable' => $this->EM,
        ];
    }
}
