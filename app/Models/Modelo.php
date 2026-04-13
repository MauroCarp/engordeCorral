<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modelo extends Model
{
    protected $fillable = [
        'nombre',
        'precio_venta_faena',
        'precio_compra_ternero',
        'precio_alimento_balanceado',
        'peso_neto_entrada',
        'peso_neto_venta',
        'mortandad',
        'consumo_promedio_ms',
        'eficiencia_conversion',
        'cabezas_jaula_compra',
        'cabezas_jaula_venta',
        'flete_compra_km',
        'flete_compra_precio',
        'flete_venta',
        'gastos_compra',
        'gastos_venta',
        'tasa_anual',
        'plazo_compra_hacienda',
        'plazo_venta_hacienda',
        'dias_financiamiento_alimento',
    ];

    protected $casts = [
        'precio_venta_faena'           => 'decimal:2',
        'precio_compra_ternero'        => 'decimal:2',
        'precio_alimento_balanceado'   => 'decimal:2',
        'peso_neto_entrada'            => 'decimal:2',
        'peso_neto_venta'              => 'decimal:2',
        'mortandad'                    => 'decimal:4',
        'consumo_promedio_ms'          => 'decimal:4',
        'eficiencia_conversion'        => 'decimal:2',
        'flete_compra_km'              => 'decimal:2',
        'flete_compra_precio'          => 'decimal:2',
        'flete_venta'                  => 'decimal:2',
        'gastos_compra'                => 'decimal:4',
        'gastos_venta'                 => 'decimal:4',
        'tasa_anual'                   => 'decimal:4',
    ];
}
