<?php

namespace App\Support;

use App\Models\Modelo;
use Illuminate\Support\Collection;

class ModeloReporteCalculator
{
    /**
     * @return array<string, float>
     */
    public function calculate(?Modelo $modelo, ?object $sanEst = null): array
    {
        $defaults = $this->defaults();

        if (! $modelo) {
            return $defaults;
        }

        $pesoNetoEntrada = (float) $modelo->peso_neto_entrada;
        $pesoNetoVenta = (float) $modelo->peso_neto_venta;
        $consumoPromedioMs = (float) $modelo->consumo_promedio_ms;
        $eficienciaConversion = (float) $modelo->eficiencia_conversion;
        $precioCompraTernero = (float) $modelo->precio_compra_ternero;
        $precioVentaFaena = (float) $modelo->precio_venta_faena;
        $precioAlimentoBalanceado = (float) $modelo->precio_alimento_balanceado;
        $mortandad = (float) $modelo->mortandad;
        $fleteCompraVentaPrecio = (float) $modelo->flete_compra_venta_precio;
        $fleteCompraKm = (float) $modelo->flete_compra_km;
        $fleteVentaKm = (float) $modelo->flete_venta_km;
        $cabezasJaulaTerneros = (float) $modelo->cabezas_jaula_terneros;
        $cabezasJaulaGordos = (float) $modelo->cabezas_jaula_gordos;
        $gastosCompra = (float) $modelo->gastos_compra;
        $gastosVenta = (float) $modelo->gastos_venta;
        $capacidadEstructura = (float) ($modelo->capacidad_estructura ?? 0);
        $tasaAnual = (float) $modelo->tasa_anual;
        $plazoCompraHacienda = (float) $modelo->plazo_compra_hacienda;
        $plazoVentaHacienda = (float) $modelo->plazo_venta_hacienda;
        $diasFinanciamientoAlimento = (float) $modelo->dias_financiamiento_alimento;

        $kgMsCabDia = $pesoNetoEntrada === $pesoNetoVenta
            ? 0.0
            : (($pesoNetoEntrada + $pesoNetoVenta) / 2) * $consumoPromedioMs;

        $adpv = $this->safeDivide($kgMsCabDia, $eficienciaConversion);
        $diasEficiencia = ($pesoNetoVenta === $pesoNetoEntrada || $adpv <= 0)
            ? 0.0
            : ($pesoNetoVenta - $pesoNetoEntrada) / $adpv;
        $mesesEficiencia = $this->safeDivide($diasEficiencia, 30);

        $fleteCompraCab = $this->safeDivide($fleteCompraVentaPrecio * $fleteCompraKm, $cabezasJaulaTerneros);
        $fleteVentaCab = $this->safeDivide($fleteCompraVentaPrecio * $fleteVentaKm, $cabezasJaulaGordos);
        $gastoCompraCab = $pesoNetoEntrada * $precioCompraTernero * $gastosCompra;
        $gastoVentaCab = ($pesoNetoVenta * (1 + $mortandad)) * $precioVentaFaena * $gastosVenta;
        $gastosComercializacion = $fleteCompraCab + $fleteVentaCab + $gastoCompraCab + $gastoVentaCab;

        $totalEstructura = $this->sumCostoMes($sanEst?->estructura ?? collect());
        $costoAmortEstructuraDia = $this->safeDivide($totalEstructura / 30.5, $capacidadEstructura);
        $costoAmortEstructuraCab = ceil($costoAmortEstructuraDia * $diasEficiencia * (1 + ($mortandad / 2)));

        $totalSanidad = $this->sumCostoMes($sanEst?->sanidad ?? collect());
        $costoSanidadCab = ceil($totalSanidad * (1 + $mortandad));

        $costoAlimentacionDia = $kgMsCabDia * $precioAlimentoBalanceado;
        $costoAlimentacionCab = $costoAlimentacionDia * $diasEficiencia * (1 + ($mortandad / 2));

        $costoSanidadDia = $this->safeDivide($costoSanidadCab, $diasEficiencia);
        $costoTotalEngordeDia = $costoAmortEstructuraDia + $costoSanidadDia + $costoAlimentacionDia;
        $costoTotalEngordeCab = $costoAmortEstructuraCab + $costoSanidadCab + $costoAlimentacionCab;
        $costoPromedioKgGanado = $this->safeDivide($costoTotalEngordeCab, $pesoNetoVenta - $pesoNetoEntrada);

        $valorTerneroInvernada = $precioCompraTernero * $pesoNetoEntrada;
        $valorTerneroGordo = $pesoNetoVenta * (1 + $mortandad) * $precioVentaFaena;

        $diasFinanciamientoHacienda = $diasEficiencia - $plazoCompraHacienda + $plazoVentaHacienda;
        $tasaAplicarHacienda = $tasaAnual / 365 * $diasFinanciamientoHacienda * 100;
        $tasaAplicarAlimento = $tasaAnual / 365 * $diasFinanciamientoAlimento * 100;
        $costoFinancieroHacienda = ($tasaAplicarHacienda / 100) * ($valorTerneroInvernada + $fleteCompraCab + $gastoCompraCab);
        $costoFinancieroAlimento = ($tasaAplicarAlimento / 100) * $costoAlimentacionCab;
        $costoFinancieroTotal = $costoFinancieroHacienda + $costoFinancieroAlimento;

        $utilidadSinCostoFinanciero = $valorTerneroGordo - $valorTerneroInvernada - $gastosComercializacion - $costoTotalEngordeCab;
        $utilidadConCostoFinanciero = $utilidadSinCostoFinanciero - $costoFinancieroTotal;

        return [
            'kgMsCabDia' => $kgMsCabDia,
            'adpv' => $adpv,
            'diasEficiencia' => $diasEficiencia,
            'mesesEficiencia' => $mesesEficiencia,
            'fleteCompraCab' => $fleteCompraCab,
            'fleteVentaCab' => $fleteVentaCab,
            'gastoCompraCab' => $gastoCompraCab,
            'gastoVentaCab' => $gastoVentaCab,
            'totalEstructura' => $totalEstructura,
            'capacidadEstructura' => $capacidadEstructura,
            'costoAmort_estructura' => $costoAmortEstructuraDia,
            'costoAmortizacionCab' => $costoAmortEstructuraCab,
            'totalSanidad' => $totalSanidad,
            'costoSanidadCab' => $costoSanidadCab,
            'costoAlimentacionDia' => $costoAlimentacionDia,
            'costoAlimentacionCab' => $costoAlimentacionCab,
            'costoTotalEngordeDia' => $costoTotalEngordeDia,
            'costoTotalEngordeCab' => $costoTotalEngordeCab,
            'costoPromedioKgGanado' => $costoPromedioKgGanado,
            'valorTerneroInvernada' => $valorTerneroInvernada,
            'valorTerneroGordo' => $valorTerneroGordo,
            'gastosComercializacion' => $gastosComercializacion,
            'diasFinanciamientoHacienda' => $diasFinanciamientoHacienda,
            'tasaAplicarHacienda' => $tasaAplicarHacienda,
            'tasaAplicarAlimento' => $tasaAplicarAlimento,
            'costoFinancieroHacienda' => $costoFinancieroHacienda,
            'costoFinancieroAlimento' => $costoFinancieroAlimento,
            'costoFinancieroTotal' => $costoFinancieroTotal,
            'utilidadSinCostoFinanciero' => $utilidadSinCostoFinanciero,
            'utilidadConCostoFinanciero' => $utilidadConCostoFinanciero,
            'impactoCompraInvernadaPct' => $this->safeDivide($valorTerneroInvernada * 100, $valorTerneroGordo),
            'impactoAlimentacionPct' => $this->safeDivide($costoAlimentacionCab * 100, $valorTerneroGordo),
            'impactoComercializacionPct' => $this->safeDivide($gastosComercializacion * 100, $valorTerneroGordo),
            'impactoEstructuraPct' => $this->safeDivide($costoAmortEstructuraCab * 100, $valorTerneroGordo),
            'impactoSanidadPct' => $this->safeDivide($costoSanidadCab * 100, $valorTerneroGordo),
        ];
    }

    /**
     * @return array<string, float>
     */
    private function defaults(): array
    {
        return [
            'kgMsCabDia' => 0.0,
            'adpv' => 0.0,
            'diasEficiencia' => 0.0,
            'mesesEficiencia' => 0.0,
            'fleteCompraCab' => 0.0,
            'fleteVentaCab' => 0.0,
            'gastoCompraCab' => 0.0,
            'gastoVentaCab' => 0.0,
            'totalEstructura' => 0.0,
            'capacidadEstructura' => 0.0,
            'costoAmort_estructura' => 0.0,
            'costoAmortizacionCab' => 0.0,
            'totalSanidad' => 0.0,
            'costoSanidadCab' => 0.0,
            'costoAlimentacionDia' => 0.0,
            'costoAlimentacionCab' => 0.0,
            'costoTotalEngordeDia' => 0.0,
            'costoTotalEngordeCab' => 0.0,
            'costoPromedioKgGanado' => 0.0,
            'valorTerneroInvernada' => 0.0,
            'valorTerneroGordo' => 0.0,
            'gastosComercializacion' => 0.0,
            'diasFinanciamientoHacienda' => 0.0,
            'tasaAplicarHacienda' => 0.0,
            'tasaAplicarAlimento' => 0.0,
            'costoFinancieroHacienda' => 0.0,
            'costoFinancieroAlimento' => 0.0,
            'costoFinancieroTotal' => 0.0,
            'utilidadSinCostoFinanciero' => 0.0,
            'utilidadConCostoFinanciero' => 0.0,
            'impactoCompraInvernadaPct' => 0.0,
            'impactoAlimentacionPct' => 0.0,
            'impactoComercializacionPct' => 0.0,
            'impactoEstructuraPct' => 0.0,
            'impactoSanidadPct' => 0.0,
        ];
    }

    /**
     * @param  iterable<int, mixed>  $items
     */
    private function sumCostoMes(iterable $items): float
    {
        $total = 0.0;

        foreach ($items as $item) {
            $total += (float) data_get($item, 'costo_mes', 0);
        }

        return $total;
    }

    private function safeDivide(float $value, float $divisor): float
    {
        if ($divisor == 0.0) {
            return 0.0;
        }

        return $value / $divisor;
    }
}