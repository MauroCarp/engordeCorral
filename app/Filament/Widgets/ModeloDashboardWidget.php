<?php

namespace App\Filament\Widgets;

use App\Models\Modelo;
use App\Models\SanidadEstructura;
use Filament\Widgets\Widget;

class ModeloDashboardWidget extends Widget
{
    protected string $view = 'filament.widgets.modelo-dashboard';
    
    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 1;

    public function getData(): array
    {
        // Obtener el primer modelo o uno por defecto
        $modelo = Modelo::first();
        
        if (!$modelo) {
            return [
                'modelo' => null,
                'mensaje' => 'No hay modelos cargados en el sistema'
            ];
        }

        // Obtener costos de sanidad y estructura
        $costoSanidad = SanidadEstructura::where('tipo', 'sanidad')->sum('costo_mes');
        $costoEstructura = SanidadEstructura::where('tipo', 'estructura')->sum('costo_mes');

        return [
            'modelo' => $modelo,
            'costoSanidad' => $costoSanidad,
            'costoEstructura' => $costoEstructura,
            'calculados' => $this->calcularMetricas($modelo, $costoSanidad, $costoEstructura)
        ];
    }

    private function calcularMetricas(Modelo $modelo, $costoSanidad, $costoEstructura): array
    {
        // Datos básicos
        $pesoInicial = $modelo->peso_neto_entrada; // kg
        $pesoFinal = $modelo->peso_neto_venta; // kg
        $gananciaTotal = $pesoFinal - $pesoInicial; // kg
        
        // Cálculos de conversión y duración
        $eficienciaConversion = $modelo->eficiencia_conversion; // kg MS/kg ganado
        $consumoPromedioMS = $modelo->consumo_promedio_ms; // % PV
        
        // Días de engorde - estimado basado en ADPV típico de 1.16 kg
        $adpvTipico = 1.16; // kg ADPV como se muestra en la imagen
        $diasEngorde = round($gananciaTotal / $adpvTipico);
        
        // Consumo total MS
        $pesoPromedio = ($pesoInicial + $pesoFinal) / 2;
        $consumoDiario = $pesoPromedio * $consumoPromedioMS;
        $consumoTotalMS = $consumoDiario * $diasEngorde;
        
        // % de Materia Seca (asumido 70% como en la imagen)
        $porcentajeMS = 0.70;
        
        // Conversión alimenticia
        $conversionAlimenticia = $consumoTotalMS / $gananciaTotal;
        
        // Costos de alimentación (el precio ya está en MS)
        $costoAlimento = $consumoTotalMS * $modelo->precio_alimento_balanceado;
        
        // Costos de transporte por cabeza
        $costeFlete = ($modelo->flete_compra_km * $modelo->flete_compra_venta_precio) + 
                      ($modelo->flete_venta_km * $modelo->flete_compra_venta_precio);
        
        // Costos de comercialización
        $valorCompra = $pesoInicial * $modelo->precio_compra_ternero;
        $valorVenta = $pesoFinal * $modelo->precio_venta_faena;
        
        $gastosCompra = $valorCompra * $modelo->gastos_compra;
        $gastosVenta = $valorVenta * $modelo->gastos_venta;
        $totalGastosComercializacion = $gastosCompra + $gastosVenta + $costeFlete;
        
        // Costos de sanidad y estructura por período
        $costoSanidadTotal = $costoSanidad * ($diasEngorde / 30); // Si es $/mes convertir a período
        $costoEstructuraTotal = $costoEstructura * ($diasEngorde / 30); // Si es $/mes convertir a período
        
        // Costo total de engorde
        $costoTotalEngorde = $costoAlimento + $costoSanidadTotal + $costoEstructuraTotal;
        
        // Costo promedio por kg ganado
        $costoPorKgGanado = $costoTotalEngorde / $gananciaTotal;
        
        // Utilidad antes de impuestos
        $utilidadAntesImpuestos = $valorVenta - $valorCompra - $totalGastosComercializacion - $costoTotalEngorde;
        
        // Cálculos financieros
        $tasaAnual = $modelo->tasa_anual;
        $plazoCompra = $modelo->plazo_compra_hacienda ?? 30;
        $plazoVenta = $modelo->plazo_venta_hacienda ?? 10;
        $diasFinanciamientoAlimento = $modelo->dias_financiamiento_alimento ?? 60;
        
        // Costo financiero hacienda (sobre valor de compra)
        $costoFinancieroHacienda = $valorCompra * ($tasaAnual / 365) * ($plazoCompra + $diasEngorde);
        
        // Costo financiero alimento (4% anual sobre costo de alimento)
        $costoFinancieroAlimento = $costoAlimento * (0.04 / 365) * $diasFinanciamientoAlimento;
        
        $costoFinancieroTotal = $costoFinancieroHacienda + $costoFinancieroAlimento;
        
        // Utilidad después de costos financieros
        $utilidadDespuesFinanciero = $utilidadAntesImpuestos - $costoFinancieroTotal;
        
        // Rentabilidad
        $inversionTotal = $valorCompra + $costoTotalEngorde + $totalGastosComercializacion;
        $rentabilidadInversion = ($utilidadDespuesFinanciero / $inversionTotal) * 100;
        $rentabilidadAnualizada = (($rentabilidadInversion / 100) * (365 / $diasEngorde)) * 100;

        return [
            'peso_inicial' => $pesoInicial,
            'peso_final' => $pesoFinal,
            'ganancia_total' => $gananciaTotal,
            'dias_engorde' => $diasEngorde,
            'adpv_tipico' => $adpvTipico,
            'peso_promedio' => $pesoPromedio,
            'consumo_diario' => $consumoDiario,
            'consumo_total_ms' => $consumoTotalMS,
            'porcentaje_ms' => $porcentajeMS * 100,
            'conversion_alimenticia' => $conversionAlimenticia,
            'costo_alimento' => $costoAlimento,
            'coste_flete' => $costeFlete,
            'gastos_compra' => $gastosCompra,
            'gastos_venta' => $gastosVenta,
            'total_gastos_comercializacion' => $totalGastosComercializacion,
            'costo_sanidad_total' => $costoSanidadTotal,
            'costo_estructura_total' => $costoEstructuraTotal,
            'costo_total_engorde' => $costoTotalEngorde,
            'costo_por_kg_ganado' => $costoPorKgGanado,
            'valor_compra' => $valorCompra,
            'valor_venta' => $valorVenta,
            'utilidad_antes_impuestos' => $utilidadAntesImpuestos,
            'costo_financiero_hacienda' => $costoFinancieroHacienda,
            'costo_financiero_alimento' => $costoFinancieroAlimento,
            'costo_financiero_total' => $costoFinancieroTotal,
            'utilidad_despues_financiero' => $utilidadDespuesFinanciero,
            'inversion_total' => $inversionTotal,
            'rentabilidad_inversion' => $rentabilidadInversion,
            'rentabilidad_anualizada' => $rentabilidadAnualizada,
            'meses_engorde' => $diasEngorde / 30,
        ];
    }
}