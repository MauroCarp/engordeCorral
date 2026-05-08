<x-filament-widgets::widget>
<style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Mono:wght@400;500&family=Instrument+Sans:wght@400;500;600&display=swap');

    .reporte-root {
        --c-bg:          #0f1117;
        --c-surface:     #161b27;
        --c-surface-2:   #1e2535;
        --c-border:      #2a3245;
        --c-accent:      #3b82f6;
        --c-accent-dim:  rgba(59,130,246,.12);
        --c-green:       #22c55e;
        --c-green-dim:   rgba(34,197,94,.10);
        --c-amber:       #f59e0b;
        --c-amber-dim:   rgba(245,158,11,.10);
        --c-muted:       #ffffff;
        --c-text:        #e2e8f0;
        --c-text-soft:   #ffffff;
        --c-heading:     #f8fafc;

        --r:  6px;
        --r2: 10px;

        font-family: 'Instrument Sans', sans-serif;
        background: var(--c-bg);
        color: var(--c-text);
        padding: 2rem;
        border-radius: var(--r2);
    }
    .financial-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 1rem;
    }

    .financial-table th,
    .financial-table td {
        border: 1px solid var(--c-border);
        padding: 0.75rem;
        text-align: center;
        font-size: 0.8rem;
    }

    .financial-table th {
        background-color: var(--c-surface-2);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .financial-table td:first-child {
        text-align: left;
        font-weight: 600;
    }

    .financial-table .highlight {
        background-color: var(--c-amber-dim);
        color: var(--c-amber);
        font-weight: bold;
    }

    .financial-table .total-row td {
        border-top: 2px solid var(--c-heading);
        font-weight: bold;
    }

    .financial-table .total-label {
        text-align: right;
        padding-right: 1rem;
    }
    .rp-value-amber {
        color: #f59e0b;
    }

    /* ── Header ─────────────────────────────────────────── */
    .rp-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid var(--c-border);
        margin-bottom: 2rem;
    }

    .rp-title-block {}

    .rp-eyebrow {
        font-family: 'DM Mono', monospace;
        font-size: 0.65rem;
        letter-spacing: .18em;
        text-transform: uppercase;
        color: var(--c-accent);
        margin-bottom: .4rem;
    }

    .rp-title {
        font-family: 'DM Serif Display', serif;
        font-size: 2rem;
        color: var(--c-heading);
        line-height: 1.1;
        margin: 0;
    }

    .rp-subtitle {
        font-size: .82rem;
        color: var(--c-muted);
        margin-top: .4rem;
    }

    .rp-meta {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: .5rem;
    }

    .rp-badge {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        background: var(--c-accent-dim);
        border: 1px solid var(--c-accent);
        color: var(--c-accent);
        font-family: 'DM Mono', monospace;
        font-size: .7rem;
        letter-spacing: .06em;
        padding: .28rem .7rem;
        border-radius: 999px;
    }

    .rp-badge-dot {
        width: 6px; height: 6px;
        border-radius: 50%;
        background: var(--c-accent);
    }

    .rp-date {
        font-family: 'DM Mono', monospace;
        font-size: .7rem;
        color: var(--c-muted);
    }

    /* ── Sections grid ───────────────────────────────────── */
    .rp-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.25rem;
    }

    .rp-grid-full {
        grid-column: 1 / -1;
    }

    /* ── Section card ────────────────────────────────────── */
    .rp-section {
        background: var(--c-surface);
        border: 1px solid var(--c-border);
        border-radius: var(--r2);
        overflow: hidden;
    }

    .rp-section-header {
        display: flex;
        align-items: center;
        gap: .6rem;
        padding: .75rem 1.1rem;
        border-bottom: 1px solid var(--c-border);
        background: var(--c-surface-2);
    }

    .rp-section-icon {
        width: 22px; height: 22px;
        display: flex; align-items: center; justify-content: center;
        border-radius: 5px;
        flex-shrink: 0;
    }

    .rp-section-icon svg {
        width: 13px; height: 13px;
    }

    .icon-blue  { background: var(--c-accent-dim); color: var(--c-accent); }
    .icon-green { background: var(--c-green-dim);  color: var(--c-green);  }
    .icon-amber { background: var(--c-amber-dim);  color: var(--c-amber);  }
    .icon-rose  { background: rgba(244,63,94,.12); color: #f43f5e;         }
    .icon-violet{ background: rgba(167,139,250,.12); color: #a78bfa;       }

    .rp-section-title {
        font-size: .72rem;
        font-weight: 600;
        letter-spacing: .1em;
        text-transform: uppercase;
        color: var(--c-text-soft);
    }

    .rp-section-body {
        padding: 1rem 1.1rem;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: .65rem 1.2rem;
    }

    .rp-section-body.cols-1 {
        grid-template-columns: 1fr;
    }

    .rp-section-body.cols-3 {
        grid-template-columns: 1fr 1fr 1fr;
    }

    /* ── Field ───────────────────────────────────────────── */
    .rp-field {
        display: flex;
        flex-direction: column;
        gap: .18rem;
        padding: .55rem .7rem;
        border-radius: var(--r);
        background: rgba(255,255,255,.02);
        border: 1px solid transparent;
        transition: border-color .15s, background .15s;
    }

    .rp-field:hover {
        background: rgba(255,255,255,.04);
        border-color: var(--c-border);
    }

    .rp-label {
        font-size: .67rem;
        letter-spacing: .04em;
        text-transform: uppercase;
        color: var(--c-muted);
        line-height: 1;
    }

    .rp-value {
        font-family: 'DM Mono', monospace;
        font-size: 0.85rem;
        font-weight: 500;
        color: var(--c-heading);
        line-height: 1.2;
    }

    .rp-unit {
        font-size: .7rem;
        color: var(--c-muted);
        font-weight: 400;
    }

    /* highlight accent on value */
    .rp-value-accent { color: var(--c-accent); }
    .rp-value-green  { color: var(--c-green);  }
    .rp-value-amber  { color: var(--c-amber);  }

    /* ── Inner nested sections (Sanidad + Nutrición) ─────── */
    .rp-nested {
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 1.25rem;
    }

    /* ── Empty state ─────────────────────────────────────── */
    .rp-empty {
        grid-column: 1/-1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: .75rem;
        padding: 4rem 2rem;
        color: var(--c-muted);
    }

    .rp-empty svg {
        width: 40px; height: 40px; opacity: .35;
    }

    .rp-empty p {
        font-size: .85rem;
        margin: 0;
    }

    /* ── Responsive ──────────────────────────────────────── */
    @media (max-width: 900px) {
        .rp-grid        { grid-template-columns: 1fr; }
        .rp-nested      { grid-template-columns: 1fr; }
        .rp-section-body.cols-3 { grid-template-columns: 1fr 1fr; }
        .rp-header      { flex-direction: column; }
        .rp-meta        { align-items: flex-start; }
    }

    @media (max-width: 560px) {
        .reporte-root      { padding: 1rem; }
        .rp-section-body   { grid-template-columns: 1fr; }
        .rp-section-body.cols-3 { grid-template-columns: 1fr; }
    }
</style>

<div class="reporte-root">

    {{-- ── Header ── --}}
    <div class="rp-header">
        <div class="rp-title-block">
            <div class="rp-eyebrow">Engorde a Corral {{$modelo->nombre}}</div>
        </div>
        {{-- @if($modelo)
        <div class="rp-meta">
            <span class="rp-badge">
                <span class="rp-badge-dot"></span>
                Registro #{{ $modelo->id }}
            </span>
            @if($modelo->created_at)
            <span class="rp-date">{{ $modelo->created_at->format('d/m/Y — H:i') }}</span>
            @endif
        </div>
        @endif --}}
    </div>

    @if(!$modelo)
    {{-- ── Empty state ── --}}
    <div class="rp-grid">
        <div class="rp-empty">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <p>No hay modelos registrados aún.</p>
        </div>
    </div>

    @else
    {{-- ── Content grid ── --}}
    <div class="rp-grid">

        {{-- Mercado --}}
        <div class="rp-section rp-grid-full">
            <div class="rp-section-header">
                <span class="rp-section-icon icon-blue">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </span>
                <span class="rp-section-title">Mercado</span>
            </div>
            <div class="rp-section-body" style="display:block">

                <table class="financial-table">
                    <tbody>
                        <tr>
                            <td>Precio Venta</td>
                            <td>{{ number_format($modelo->precio_venta_faena, 1, ',', '.') }}<span class="rp-unit">$/Kg</span></td>
                        </tr>
                        <tr>
                            <td>Precio Compra</td>
                            <td>
                                <span class="rp-value rp-value-accent">
                                    {{ number_format($modelo->precio_compra_ternero, 1, ',', '.') }}
                                    <span class="rp-unit">$/Kg</span>
                                </span>
                            </td>
                        </tr>
                            <td>Peso Neto Ingreso</td>
                            <td>
                                <span class="rp-value rp-value-accent">
                                    {{ number_format($modelo->peso_neto_entrada, 1, ',', '.') }}
                                    <span class="rp-unit">$/Kg</span>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>Peso Neto Venta</td>
                            <td>
                                <span class="rp-value">
                                    {{ number_format($modelo->peso_neto_venta, 2, ',', '.') }}
                                    <span class="rp-unit">Kg</span>
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Nutrición --}}
        <div class="rp-section rp-grid-full">
            <div class="rp-section-header">
                <span class="rp-section-icon icon-violet">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                    </svg>
                </span>
                <span class="rp-section-title">Nutrición</span>
            </div>
            <div class="rp-section-body" style="display:block">
                <table class="financial-table">
                    <tbody>
                        <tr>
                            <td colspan="2">Precio TC alimento</td>
                            <td>
                                <span class="rp-value">
                                    {{ number_format($modelo->precio_alimento_balanceado, 1, ',', '.') }}
                                    <span class="rp-unit">% de Materia Seca</span>
                                </span>
                            </td>
                            <td>
                                <span class="rp-value">
                                    {{ number_format($modelo->eficiencia_conversion, 1, ',', '.') }}
                                    <span class="rp-unit">$/Kg(MS)</span>
                                </span>
                            </td>
                            <td><span class="rp-value">
                                    {{ number_format($modelo->eficiencia_conversion, 1, ',', '.') }}
                                    <span class="rp-unit">$/Kg</span>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">Consumo promedio MS en terminación</td>
                            <td>
                                <span class="rp-value">
                                    {{ number_format($modelo->consumo_promedio_ms, 1, ',', '.') }}
                                    <span class="rp-unit">% PV</span>
                                </span>
                            </td>
                            <td>
                               <span class="rp-value">
                                    {{ number_format($modelo->eficiencia_conversion, 1, ',', '.') }}
                                    <span class="rp-unit">Kg MS/Cab dia</span>
                                </span> 
                            </td>
                            <td>
                               <span class="rp-value">
                                    {{ number_format($modelo->eficiencia_conversion, 1, ',', '.') }}
                                    <span class="rp-unit">$/dia</span>
                                </span> 
                            </td>
                        </tr>
                        <tr>
                            <td>Eficiencia conversión y Ciclo terminación</td>
                            <td>
                                <span class="rp-value">
                                    {{ number_format($modelo->consumo_promedio_ms, 1, ',', '.') }}
                                    <span class="rp-unit">Kg MS/Kg carne</span>
                                </span>
                            </td>
                            <td>
                                <span class="rp-value">
                                    {{ number_format($modelo->eficiencia_conversion, 1, ',', '.') }}
                                    <span class="rp-unit">Kg ADPV</span>
                                </span>
                            </td>
                            <td>
                                <span class="rp-value">
                                    {{ number_format($modelo->eficiencia_conversion, 0, ',', '.') }}
                                    <span class="rp-unit">Meses</span>
                                </span>
                            </td>
                            <td>
                                <span class="rp-value">
                                    {{ number_format($modelo->eficiencia_conversion, 0, ',', '.') }}
                                    <span class="rp-unit">Dias</span>
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

           {{-- Comercialización (full width) --}}
        <div class="rp-section rp-grid-full">
            <div class="rp-section-header">
                <span class="rp-section-icon icon-amber">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                    </svg>
                </span>
                <span class="rp-section-title">Comercialización</span>
            </div>
            <div class="rp-section-body" style="grid-template-columns: 1fr">
                <table class="financial-table">
                    <thead>
                        <tr>
                            <th>Cabezas/jaula</th>
                            <th colspan="4">{{ $modelo->cabezas_jaula_terneros }} terneras/os - {{ $modelo->cabezas_jaula_gordos }} gordos</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Flete compra</td>
                            <td rowspan="2">3.737,00 $/km</td>
                            <td>(600 km)</td>
                            <td>$/kg 215,596</td>
                            <td>34.495,38 $/cab.</td>
                        </tr>
                        <tr>
                            <td>Flete venta</td>
                            <td>(70 km)</td>
                            <td>$/kg 13,768</td>
                            <td>5.231,80 $/cab.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- COSTO --}}
        <div class="rp-section rp-grid-full">
            <div class="rp-section-header">
                <span class="rp-section-icon icon-blue">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </span>
                <span class="rp-section-title">COSTOS</span>
            </div>
            <div class="rp-section-body" style="display:block">

                <table class="financial-table">
                    <tbody>
                        <tr>
                            <td>Costo Amortización / Estructura/Personal *</td>
                            <td style="text-align: right;">311,48 $/día/cab</td>
                            <td style="text-align: right;">59.515 $/cab.</td>
                        </tr>
                        <tr>
                            <td>Costo Sanidad e identificación</td>
                            <td style="text-align: right;">$/cab 7.074,00</td>
                            <td style="text-align: right;">7.145 $/cab.</td>
                        </tr>
                        <tr>
                            <td>Costo Alimentación</td>
                            <td style="text-align: right;">2.268,0 $/día</td>
                            <td style="text-align: right;">433.356,0 $/cab.</td>
                        </tr>
                        <tr>
                            <td>Costos totales Engorde</td>
                            <td style="text-align: right;">2.630,0 $/día</td>
                            <td style="text-align: right;">500.015,6 $/cab.</td>
                        </tr>
                        <tr>
                            <td colspan="2">Costo promedio/kg ganado</td>
                            <td style="text-align: right;">2.272,80 $/kg</td>
                        </tr>
                        <tr>
                            <td colspan="2">Valor ternero invernada</td>
                            <td style="text-align: right;">$ 1.040.000,0</td>
                        </tr>
                        <tr>
                            <td colspan="2">Costos totales Engorde</td>
                            <td style="text-align: right;">$ 500.015,6</td>
                        </tr>
                        <tr>
                            <td colspan="2">Gastos de comercialización</td>
                            <td style="text-align: right;">$ 130.800,0</td>
                        </tr>
                        <tr>
                            <td colspan="2">Valor ternero gordo</td>
                            <td style="text-align: right;">$ 1.956.240,0</td>
                        </tr>
                        <tr class="total-row">
                            <td colspan="2" class="total-label">Utilidad <span class="highlight">antes de impuestos nacionales y provinciales</span> SIN costo financiero</td>
                            <td class="highlight" style="background-color: #28a745; color: white; text-align: right;">$ 285.424,40</td>
                        </tr>
                    </tbody>
                </table>
                
            </div>
        </div>

        {{-- Financiero --}}
        <div class="rp-section rp-grid-full">
            <div class="rp-section-header">
                <span class="rp-section-icon icon-green">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                    </svg>
                </span>
                <span class="rp-section-title">Costo Financiero</span>
            </div>
            <div class="rp-section-body" style="grid-template-columns: 1fr">
                <div style="display: flex; justify-content: flex-end; align-items: center; gap: 1rem;">
                    <span class="rp-label" style="font-size: 0.8rem;">Tasa anual</span>
                    <span class="rp-value rp-value-amber highlight" style="padding: 0.5rem 1rem; border-radius: var(--r);">
                        {{ number_format($modelo->tasa_anual, 2, ',', '.') }}%
                    </span>
                </div>

                <table class="financial-table" style="margin-top: 0;">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Plazo compra</th>
                            <th>Plazo venta</th>
                            <th>Días de financiamiento</th>
                            <th>Tasa a aplicar</th>
                            <th>Costo Financiero</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Hacienda</td>
                            <td class="highlight">{{ $modelo->plazo_compra_hacienda }} días</td>
                            <td class="highlight">{{ $modelo->plazo_venta_hacienda }} días</td>
                            <td class="highlight">170 días</td>
                            <td>12%</td>
                            <td>$ 128.838,85</td>
                        </tr>
                        <tr>
                            <td>Alimento</td>
                            <td>(pago AB cada 15 días)</td>
                            <td></td>
                            <td class="highlight">60 días</td>
                            <td>4%</td>
                            <td>$ 17.809,15</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr class="total-row">
                            <td colspan="5" class="total-label">Costo financiero total</td>
                            <td>$ 146.648,00</td>
                        </tr>
                        <tr class="total-row">
                            <td colspan="5" class="total-label">Utilidad <span class="highlight">antes de impuestos nacionales y provinciales</span> CON costo financiero</td>
                            <td class="highlight" style="background-color: #28a745; text-align: right;">$ 138.776,40</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

     
                        {{-- Sanidad --}}
                {{-- <div class="rp-section">
                    <div class="rp-section-header">
                        <span class="rp-section-icon icon-rose">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                        </span>
                        <span class="rp-section-title">Sanidad</span>
                    </div>
                    <div class="rp-section-body cols-1">
                        <div class="rp-field">
                            <span class="rp-label">Mortandad</span>
                            <span class="rp-value" style="font-size:1.5rem">
                                {{ number_format($modelo->mortandad, 1, ',', '.') }}
                                <span class="rp-unit">%</span>
                            </span>
                        </div>
                    </div>
                </div>
                 --}}
        {{-- Sanidad + Nutrición side by side (full width) --}}
        


    </div>{{-- /rp-grid --}}
    @endif

</div>{{-- /reporte-root --}}
</x-filament-widgets::widget>
