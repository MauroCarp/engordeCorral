<?php

/**
 * Modelo de cálculo para Engorde a Corral
 * Basado en el archivo prueba.xls
 * 
 * Las celdas amarillas (inputs principales) se definen al inicio.
 * Luego se calculan todas las variables derivadas.
 * Cada variable incluye un comentario explicando qué representa o cómo se calcula.
 */

// ==============================================
// 1. DEFINICIÓN DE VARIABLES DE ENTRADA (celdas amarillas)
// ==============================================

// Mercado
$precio_venta_faena = 5200;      // Precio de venta a faena ($/kg)
$precio_compra_ternero = 6500;   // Precio de compra del ternero al destete ($/kg)
$peso_neto_entrada = 160;        // Peso neto de entrada (kg)
$peso_neto_venta = 380;          // Peso neto de venta (kg)

// Nutrición
$porcentaje_materia_seca = 0.7;  // % de materia seca del alimento
$precio_tal_cual_alimento = 196; // Precio "tal cual" del alimento ($/kg)
$consumo_promedio_MS = 0.03;     // Consumo promedio de MS en terminación (% del peso vivo)
$eficiencia_conversion = 6;      // Eficiencia de conversión (kg alimento / kg ganancia)

// Comercialización
$cabezas_jaula = 65;             // Cabezas por jaula
$flete_compra = 3737;            // Flete de compra ($/viaje)
$flete_venta = 70;               // Flete de venta ($/kg)
$gastos_compra_porc = 0.03;      // Gastos de compra (% sobre valor compra)
$gastos_venta_porc = 0.03;       // Gastos de venta (% sobre valor venta)

// Sanidad
$tasa_mortandad = 0.01;          // Mortandad (%)
$costo_sanidad_por_cabeza = 7074; // Costo de sanidad e identificación por cabeza ($)

// Estructura (costos fijos)
$costo_estructura_por_cabeza_dia = 311.475; // Costo amortización/estructura/personal ($/cab/día)

// Financiero
$tasa_anual = 0.25;              // Tasa anual de interés
$plazo_compra_dias = 30;         // Plazo pago compra de hacienda (días)
$plazo_venta_dias = 10;          // Plazo cobro venta de hacienda (días)
$dias_financiamiento_alimento = 60; // Días de financiamiento para alimento

// ==============================================
// 2. CÁLCULOS DE VARIABLES DERIVADAS
// ==============================================

// ----------------------------------------------
// Parámetros productivos
// ----------------------------------------------

// Ganancia total de peso por animal (kg)
$ganancia_peso = $peso_neto_venta - $peso_neto_entrada; // 380 - 160 = 220 kg

// Consumo de MS total por animal (kg MS)
// Se calcula como: ganancia de peso * eficiencia de conversión
$consumo_MS_total = $ganancia_peso * $eficiencia_conversion; // 220 * 6 = 1320 kg MS

// Consumo de MS diario por animal (kg MS/día)
// Primero calculamos el peso vivo promedio aproximado
$peso_promedio = ($peso_neto_entrada + $peso_neto_venta) / 2; // (160+380)/2 = 270 kg
$consumo_MS_diario = $peso_promedio * $consumo_promedio_MS; // 270 * 0.03 = 8.1 kg MS/día

// Días de engorde (días)
$dias_engorde = $consumo_MS_total / $consumo_MS_diario; // 1320 / 8.1 ≈ 162.96 días

// Consumo de alimento "tal cual" total por animal (kg)
// Se ajusta por el % de materia seca
$consumo_tal_cual_total = $consumo_MS_total / $porcentaje_materia_seca; // 1320 / 0.7 ≈ 1885.71 kg

// ----------------------------------------------
// Costos directos por animal
// ----------------------------------------------

// Costo de compra del ternero ($/animal)
$costo_compra_ternero = $precio_compra_ternero * $peso_neto_entrada; // 6500 * 160 = 1,040,000

// Costo de alimentación total ($/animal)
$costo_alimentacion = $consumo_tal_cual_total * $precio_tal_cual_alimento; // 1885.71 * 196 ≈ 369,600

// Costo de sanidad por animal ($/animal)
$costo_sanidad = $costo_sanidad_por_cabeza; // 7,074

// Costo de estructura por animal ($/animal)
$costo_estructura = $costo_estructura_por_cabeza_dia * $dias_engorde; // 311.475 * 162.96 ≈ 50,750

// ----------------------------------------------
// Gastos de comercialización
// ----------------------------------------------

// Valor bruto de compra del lote (base 1 animal)
$valor_compra_bruto = $costo_compra_ternero; // 1,040,000

// Gastos de compra (comisión, etc)
$gastos_compra = $valor_compra_bruto * $gastos_compra_porc; // 1,040,000 * 0.03 = 31,200

// Flete compra por animal (asumiendo que el flete_compra es por jaula)
$flete_compra_por_animal = $flete_compra / $cabezas_jaula; // 3737 / 65 ≈ 57.49

// Valor bruto de venta por animal
$peso_neto_venta_ajustado = $peso_neto_venta * (1 - $tasa_mortandad); // 380 * 0.99 = 376.2 kg
$valor_venta_bruto = $precio_venta_faena * $peso_neto_venta_ajustado; // 5200 * 376.2 ≈ 1,956,240

// Gastos de venta (comisión, etc)
$gastos_venta = $valor_venta_bruto * $gastos_venta_porc; // 1,956,240 * 0.03 ≈ 58,687

// Flete venta por animal
$flete_venta_por_animal = $flete_venta * $peso_neto_venta_ajustado; // 70 * 376.2 ≈ 26,334

// Total gastos de comercialización por animal
$total_gastos_comercializacion = $gastos_compra + $flete_compra_por_animal + $gastos_venta + $flete_venta_por_animal;
// ≈ 31,200 + 57.49 + 58,687 + 26,334 ≈ 116,278

// ----------------------------------------------
// Costos totales y resultado por animal
// ----------------------------------------------

// Costos totales de engorde (sin gastos financieros)
$costos_totales_engorde = $costo_alimentacion + $costo_sanidad + $costo_estructura;
// ≈ 369,600 + 7,074 + 50,750 ≈ 427,424

// Costo total por animal (incluye compra + engorde + comercialización)
$costo_total_por_animal = $costo_compra_ternero + $costos_totales_engorde + $total_gastos_comercializacion;
// ≈ 1,040,000 + 427,424 + 116,278 ≈ 1,583,702

// Utilidad antes de impuestos y costo financiero ($/animal)
$utilidad_bruta = $valor_venta_bruto - $costo_total_por_animal;
// ≈ 1,956,240 - 1,583,702 ≈ 372,538

// ----------------------------------------------
// Costo financiero
// ----------------------------------------------

// Días de financiamiento para hacienda
// Desde la compra hasta la venta, considerando plazos de pago y cobro
$dias_financiamiento_hacienda = $dias_engorde + $plazo_compra_dias + $plazo_venta_dias;
// ≈ 162.96 + 30 + 10 ≈ 202.96 días

// Tasa a aplicar para hacienda (interés para el período)
$tasa_aplicar_hacienda = pow(1 + $tasa_anual, $dias_financiamiento_hacienda / 365) - 1;
// Ejemplo: (1+0.25)^(202.96/365) - 1 ≈ 0.1305 (13.05%)

// Costo financiero de la hacienda
$costo_financiero_hacienda = ($costo_compra_ternero + $gastos_compra + $flete_compra_por_animal) * $tasa_aplicar_hacienda;
// Base financiable: compra + gastos compra + flete compra

// Costo financiero del alimento (pago cada 15 días, se financia 60 días)
$tasa_aplicar_alimento = (1 + $tasa_anual) ^ ($dias_financiamiento_alimento / 365) - 1;
// Ejemplo: (1+0.25)^(60/365) - 1 ≈ 0.0375 (3.75%)
// Nota: se simplifica, el original usa 0.04109 (tasa por 60 días directa)

$costo_financiero_alimento = $costo_alimentacion * $tasa_aplicar_alimento;

// Costo financiero total por animal
$costo_financiero_total = $costo_financiero_hacienda + $costo_financiero_alimento;

// Utilidad neta (con costo financiero)
$utilidad_neta = $utilidad_bruta - $costo_financiero_total;

// ----------------------------------------------
// Indicadores de rentabilidad
// ----------------------------------------------

// Inversión total promedio (capital invertido)
// Aproximación: compra + engorde + comercialización antes de cobrar venta
$inversion_total = $costo_compra_ternero + $costos_totales_engorde + $total_gastos_comercializacion;

// Renta sobre inversión (para el ciclo)
$renta_sobre_inversion = $utilidad_neta / $inversion_total;

// Renta anualizada
$dias_ciclo = $dias_engorde + $plazo_compra_dias + $plazo_venta_dias; // mismos días financiamiento
$ciclos_por_anio = 365 / $dias_ciclo;
$renta_anualizada = pow(1 + $renta_sobre_inversion, $ciclos_por_anio) - 1;

// ----------------------------------------------
// Costo por kilo ganado
// ----------------------------------------------
$costo_por_kilo_ganado = ($costos_totales_engorde + $total_gastos_comercializacion) / $ganancia_peso;

// ==============================================
// 3. RESULTADOS FINALES
// ==============================================

echo "=== RESULTADOS DEL MODELO DE ENGORDE A CORRAL ===\n\n";

echo "Parámetros productivos:\n";
echo "  - Ganancia de peso por animal: " . number_format($ganancia_peso, 2) . " kg\n";
echo "  - Días de engorde: " . number_format($dias_engorde, 2) . " días\n";
echo "  - Consumo MS total: " . number_format($consumo_MS_total, 2) . " kg MS\n";
echo "  - Consumo tal cual total: " . number_format($consumo_tal_cual_total, 2) . " kg\n\n";

echo "Costos por animal:\n";
echo "  - Compra ternero: $" . number_format($costo_compra_ternero, 2) . "\n";
echo "  - Alimentación: $" . number_format($costo_alimentacion, 2) . "\n";
echo "  - Sanidad: $" . number_format($costo_sanidad, 2) . "\n";
echo "  - Estructura: $" . number_format($costo_estructura, 2) . "\n";
echo "  - Gastos comercialización: $" . number_format($total_gastos_comercializacion, 2) . "\n";
echo "  - Costo financiero total: $" . number_format($costo_financiero_total, 2) . "\n\n";

echo "Ingresos por animal:\n";
echo "  - Venta bruta: $" . number_format($valor_venta_bruto, 2) . "\n\n";

echo "Resultados:\n";
echo "  - Utilidad bruta (sin costo financiero): $" . number_format($utilidad_bruta, 2) . "\n";
echo "  - Utilidad neta (con costo financiero): $" . number_format($utilidad_neta, 2) . "\n";
echo "  - Costo por kg ganado: $" . number_format($costo_por_kilo_ganado, 2) . "/kg\n\n";

echo "Rentabilidad:\n";
echo "  - Renta sobre inversión (ciclo): " . number_format($renta_sobre_inversion * 100, 2) . "%\n";
echo "  - Renta anualizada: " . number_format($renta_anualizada * 100, 2) . "%\n";

?>