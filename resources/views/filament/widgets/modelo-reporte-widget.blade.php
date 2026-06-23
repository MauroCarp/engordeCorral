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

    .rp-modelo-select {
        min-width: 240px;
        background: var(--c-surface-2);
        border: 1px solid var(--c-border);
        color: var(--c-heading);
        font-family: 'DM Mono', monospace;
        font-size: .78rem;
        border-radius: var(--r);
        padding: .45rem .65rem;
        outline: none;
    }

    .rp-modelo-select:focus {
        border-color: var(--c-accent);
        box-shadow: 0 0 0 2px var(--c-accent-dim);
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
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 1.25rem;
    }

    /* .rp-grid-full {
        grid-column: 1 / -1;
    } */

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

    /* ── Breakeven ───────────────────────────────────────── */
    .rp-breakeven {
        display: flex;
        flex-wrap: wrap;
        gap: 1.25rem;
        margin-top: 0.5rem;
    }

    .rp-breakeven-item {
        display: flex;
        align-items: center;
        gap: 0.85rem;
        flex: 1 1 280px;
    }

    .rp-breakeven-btn {
        font-family: 'Instrument Sans', sans-serif;
        font-size: 0.78rem;
        font-weight: 600;
        letter-spacing: 0.03em;
        padding: 0.55rem 1rem;
        border-radius: var(--r);
        border: 1px solid var(--c-border);
        background: var(--c-surface-2);
        color: var(--c-heading);
        cursor: pointer;
        white-space: nowrap;
        transition: border-color 0.15s, background 0.15s, opacity 0.15s;
    }

    .rp-breakeven-btn:hover:not(:disabled) {
        border-color: var(--c-accent);
        background: var(--c-accent-dim);
        color: var(--c-accent);
    }

    .rp-breakeven-btn:disabled {
        opacity: 0.55;
        cursor: wait;
    }

    .rp-breakeven-btn--gordo:hover:not(:disabled) {
        border-color: var(--c-green);
        background: var(--c-green-dim);
        color: var(--c-green);
    }

    .rp-breakeven-btn--invernada:hover:not(:disabled) {
        border-color: var(--c-amber);
        background: var(--c-amber-dim);
        color: var(--c-amber);
    }

    .rp-breakeven-item--reset {
        flex: 0 0 auto;
        align-self: center;
    }

    .rp-breakeven-btn--reset:hover:not(:disabled) {
        border-color: var(--c-muted);
        background: rgba(255, 255, 255, 0.06);
        color: var(--c-heading);
    }

    .rp-breakeven-result {
        flex: 1;
        min-width: 120px;
        padding: 0.55rem 0.85rem;
        border-radius: var(--r);
        border: 1px solid var(--c-border);
        background: rgba(255, 255, 255, 0.03);
        font-family: 'DM Mono', monospace;
        font-size: 0.85rem;
        font-weight: 500;
        color: var(--c-heading);
        text-align: center;
    }

    .rp-breakeven-result--active {
        border-color: var(--c-accent);
        background: var(--c-accent-dim);
        color: var(--c-accent);
    }

    .rp-breakeven-result--gordo.rp-breakeven-result--active {
        border-color: var(--c-green);
        background: var(--c-green-dim);
        color: var(--c-green);
    }

    .rp-breakeven-result--invernada.rp-breakeven-result--active {
        border-color: var(--c-amber);
        background: var(--c-amber-dim);
        color: var(--c-amber);
    }

    .rp-breakeven-placeholder {
        color: var(--c-muted);
        font-weight: 400;
        font-size: 0.75rem;
    }

    .rp-value-breakeven {
        color: var(--c-accent);
    }
</style>

<div class="reporte-root modelo-reporte-loading-host">

    @include('filament.widgets.partials.modelo-reporte-loading', [
        'targets' => 'selectedModeloId, updatedSelectedModeloId, calcularBreakevenGordo, calcularBreakevenInvernada, reestablecerBreakeven, refreshDashboardWidgets',
    ])

    {{-- ── Header ── --}}
    <div class="rp-header">
        <div class="rp-title-block">
            <div class="rp-eyebrow">Engorde a Corral {{ $modelo?->nombre ?? 'Sin modelo' }}</div>
            
        </div>
        <div class="rp-meta">
            <select wire:model.live="selectedModeloId" class="rp-modelo-select">
                <option value="">Seleccionar modelo</option>
                @foreach($modeloOptions as $id => $nombre)
                    <option value="{{ $id }}">{{ $nombre }}</option>
                @endforeach
            </select>
        </div>
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
        <div class="rp-section">
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
                            <td>Precio Compra</td>
                            <td>
                            <span class="rp-value @if($breakevenInvernada !== null) rp-value-breakeven @endif">
                                {{ number_format($modeloReporte->precio_compra_ternero, $breakevenInvernada !== null ? 2 : 1, ',', '.') }}
                                <span class="rp-unit">$/Kg</span>
                            </span>
                            </td>
                        </tr>
                        <tr>
                            <td>Precio Venta</td>
                            <td>
                                <span class="rp-value @if($breakevenGordo !== null) rp-value-breakeven @endif">
                                    {{ number_format($modeloReporte->precio_venta_faena, $breakevenGordo !== null ? 2 : 1, ',', '.') }}<span class="rp-unit">$/Kg</span>
                                </span>
                            </td>
                        </tr>
                            <td>Peso Neto Ingreso</td>
                            <td>
                                <span class="rp-value">
                                    {{ number_format($modelo->peso_neto_entrada, 1, ',', '.') }}
                                    <span class="rp-unit">Kg/Cab</span>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>Peso Neto Venta</td>
                            <td>
                                <span class="rp-value">
                                    {{ number_format($modelo->peso_neto_venta, 2, ',', '.') }}
                                    <span class="rp-unit">Kg/Ca</span>
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Nutrición --}}
        <div class="rp-section">
            <div class="rp-section-header">
                <span class="rp-section-icon icon-violet">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                    </svg>
                </span>
                <span class="rp-section-title">Nutrición</span>
                 | 
                <span class="rp-section-icon icon-rose">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                        </span>
                        <span class="rp-section-title">Sanidad</span>
            </div>
            <div class="rp-section-body" style="display:block">
                <table class="financial-table">
                    <tbody>
                        <tr>
                            <td colspan="2">Precio TC alimento</td>
                            <td>
                                <span class="rp-value">
                                    {{ number_format($dietaAverages['porcentaje_ms'], 1, ',', '.') }}
                                    <span class="rp-unit">% de Materia Seca</span>
                                </span>
                            </td>
                            <td>
                                <span class="rp-value">

                                    {{ number_format($dietaAverages['costo_kg_tc'] / ($dietaAverages['porcentaje_ms'] / 100), 1, ',', '.') }}
                                    <span class="rp-unit">$/Kg(MS)</span>
                                </span>
                            </td>
                            <td><span class="rp-value">
                                    {{ number_format($dietaAverages['costo_kg_tc'], 1, ',', '.') }}
                                    <span class="rp-unit">$/Kg</span>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>Consumo promedio MS en terminación</td>
                            <td>
                                <span class="rp-value">
                                    {{ number_format($modelo->consumo_promedio_ms * 100, 1, ',', '.') }}
                                    <span class="rp-unit">% PV</span>
                                </span>
                            </td>
                            <td>
                               <span class="rp-value">
                                @php
                                    $kgMsCabDia = (($modelo->peso_neto_entrada + $modelo->peso_neto_venta) / 2) * $modelo->consumo_promedio_ms;
                                @endphp
                                    {{ number_format($kgMsCabDia, 2, ',', '.') }}
                                    <span class="rp-unit">Kg MS/Cab dia</span>
                                </span> 
                            </td>
                            <td>
                               <span class="rp-value">
                                @php
                                    $kgMvCabDia = $kgMsCabDia / $dietaAverages['porcentaje_ms'] * 100;
                                @endphp
                                    {{ number_format($kgMvCabDia, 2, ',', '.') }}
                                    <span class="rp-unit">Kg MV/Cab dia</span>
                                </span> 
                            </td>
                            <td>
                                {{-- @dd($dietaAverages); --}}
                               <span class="rp-value">
                                    {{ number_format($kgMvCabDia * $dietaAverages['costo_kg_tc'], 1, ',', '.') }}

                                    <span class="rp-unit">$/dia</span>
                                </span> 
                            </td>
                        </tr>
                        <tr>
                            <td>Eficiencia conversión y Ciclo terminación</td>
                            <td>
                                <span class="rp-value">
                                    {{ number_format($modelo->eficiencia_conversion, 1, ',', '.') }}
                                    <span class="rp-unit">Kg MS/Kg carne</span>
                                </span>
                            </td>
                            <td>
                                <span class="rp-value">
                                    {{ number_format($kgMsCabDia / $modelo->eficiencia_conversion, 2, ',', '.') }}
                                    <span class="rp-unit">Kg ADPV</span>
                                </span>
                            </td>
                            <td>
                                <span class="rp-value">
                                    {{ number_format($mesesEficiencia, 0, ',', '.') }}
                                    <span class="rp-unit">Meses</span>
                                </span>
                            </td>
                            <td>
                                <span class="rp-value">
                                    {{ number_format($diasEficiencia, 0, ',', '.') }}
                                    <span class="rp-unit">Dias</span>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>Mortandad</td>
                            <td colspan="3">
                            </td>
                            <td>
                                <span class="rp-value">
                                    {{ number_format($modelo->mortandad * 100, 1, ',', '.') }}
                                    <span class="rp-unit">%</span>
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

           {{-- Comercialización (full width) --}}
        <div class="rp-section">
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
                            <td rowspan="2">{{ number_format($modelo->flete_compra_venta_precio,2,',','.') }} $/km</td>
                            <td>({{ number_format($modelo->flete_compra_km,0,',','.') }} km)</td>
                            <td>$/kg {{ number_format($modelo->peso_neto_entrada > 0 ? ($fleteCompraCab / $modelo->peso_neto_entrada) : 0,2,',','.') }}</td>
                            <td>{{ number_format($fleteCompraCab,2,',','.') }} $/cab.</td>
                        </tr>
                        <tr>
                            <td>Flete venta</td>
                            <td>({{ number_format($modelo->flete_venta_km,0,',','.') }} km)</td>
                            <td>$/kg {{ number_format($modelo->peso_neto_entrada > 0 ? ($fleteVentaCab / $modelo->peso_neto_venta) : 0,2,',','.') }}</td>
                            <td>{{ number_format($fleteVentaCab,2,',','.') }} $/cab.</td>
                        </tr>
                        <tr>
                            <td>Costo de compra (%)</td>
                            <td style="text-align: center;">{{ number_format($modelo->gastos_compra * 100, 2, ',', '.') }}%</td>
                            <td></td>
                        {{-- @dd($modelo->peso_neto_entrada,$modelo->gastos_compra,$modelo->precio_compra_ternero) --}}
                            <td>$/kg {{ number_format($modelo->peso_neto_entrada > 0 ? ($gastoCompraCab / $modelo->peso_neto_entrada) : 0,2,',','.') }}</td>
                            <td>{{ number_format($gastoCompraCab,2,',','.') }} $/cab.</td>
                        </tr>
                        <tr>
                            <td>Costo de venta (%)</td>
                            <td style="text-align: center;">{{ number_format($modelo->gastos_venta * 100, 2, ',', '.') }}%</td>
                            <td></td>
                            <td>$/kg {{ number_format($modelo->peso_neto_venta > 0 ? ($gastoVentaCab / $modelo->peso_neto_venta) : 0,2,',','.') }}</td>
                            <td>{{ number_format($gastoVentaCab,2,',','.') }} $/cab.</td>

                        </tr>
                        <tr>
                            <td>Total Gastos de Comercializacion</td>
                            <td colspan="3"></td>
                            <td>{{ number_format(ceil($gastosComercializacion),2,',','.') }} $/cab.</td>
                        </tr>
                        
                    </tbody>
                </table>
            </div>
        </div>

        {{-- COSTO --}}
        <div class="rp-section">
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
                            <td style="text-align: right;">{{ number_format($costoAmort_estructura,2,',','.') }} $/día/cab</td>
                            <td style="text-align: right;">{{ number_format($costoAmortizacionCab,2,',','.') }} $/cab.</td>
                        </tr>
                        <tr>
                            <td>Costo Sanidad e identificación</td>
                            <td style="text-align: right;">$/cab {{ number_format($totalSanidad,2,',','.') }}</td>
                            <td style="text-align: right;">{{ number_format($costoSanidadCab,2,',','.') }} $/cab.</td>
                        </tr>
                        <tr>
                            <td>Costo Alimentación</td>
                            <td style="text-align: right;">
                                {{ number_format($kgMvCabDia * $dietaAverages['costo_kg_tc'],1,',','.') }} $/cab.
                            </td>
                            <td style="text-align: right;">
                                @php
                                    if (! $usaCalculoBreakeven) {
                                        $costoAlimentacionCab = ($kgMvCabDia * $dietaAverages['costo_kg_tc']) * $diasEficiencia * (1 + ($modelo->mortandad / 2));
                                    }
                                @endphp
                                {{ number_format($costoAlimentacionCab,1,',','.') }} $/día
                            </td>
                        </tr>
                        <tr>
                            <td>Costos totales Engorde</td>
                            @php
                                $costoTotalEngorde = $usaCalculoBreakeven
                                    ? $costoTotalEngordeCab
                                    : $costoAmortizacionCab + $costoSanidadCab + $costoAlimentacionCab;
                            @endphp
                            <td style="text-align: right;">{{ number_format($costoTotalEngorde / $diasEficiencia,2,',','.') }} $/día</td>
                            <td style="text-align: right;">{{ number_format($costoTotalEngorde,2,',','.') }} $/cab.</td>
                        </tr>
                        <tr>
                            <td>Costo promedio/kg ganado</td>
                            <td></td>
                            <td style="text-align: right;">{{ number_format($costoPromedioKgGanado,2,',','.') }} $/kg</td>
                        </tr>
                        <tr>
                            <td>Valor ternero invernada</td>
                            <td></td>
                            <td style="text-align: right;">$ {{ number_format($valorTerneroInvernada,2,',','.') }}</td>
                        </tr>
                        <tr>
                            <td>Gastos de comercialización</td>
                            <td></td>
                            <td style="text-align: right;">$ {{ number_format(ceil($gastosComercializacion),2,',','.') }}.</td>

                        </tr>
                        <tr>
                            <td>Valor ternero gordo</td>
                            <td></td>
                            <td style="text-align: right;">$ {{ number_format($usaCalculoBreakeven ? $valorTerneroGordo : $modelo->precio_venta_faena * $modelo->peso_neto_venta * (1 - $modelo->mortandad),2,',','.') }}</td>
                        </tr>
                        <tr class="total-row">
                            <td colspan="2" class="total-label">Utilidad <span class="highlight">antes de impuestos nacionales y provinciales</span> SIN costo financiero</td>
                            @php
                                $utilidadAntesImpuestos = $usaCalculoBreakeven
                                    ? $utilidadSinCostoFinanciero
                                    : $valorTerneroGordo - $gastosComercializacion - $costoTotalEngorde - $valorTerneroInvernada;
                            @endphp
                            <td class="highlight rp-value-accent" style="text-align: right;">$ {{ number_format($utilidadAntesImpuestos,2,',','.') }}</td>
                        </tr>
                    </tbody>
                </table>
                
            </div>
        </div>

        {{-- Financiero --}}
        <div class="rp-section">
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
                        {{ number_format($modelo->tasa_anual * 100, 2, ',', '.') }}%
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
                            <td>{{ $modelo->plazo_compra_hacienda }} días</td>
                            <td>{{ $modelo->plazo_venta_hacienda }} días</td>
                            <td>{{ number_format($diasFinanciamientoHacienda,0) }} días</td>
                            <td>{{ round($tasaAplicarHacienda) }}%</td>
                            <td>$ {{ number_format($costoFinancieroHacienda,2,',','.') }}</td>

                        </tr>
                        <tr>
                            <td>Alimento</td>
                            <td colspan="2">(pago AB cada 15 días)</td>
                            <td>{{ $modelo->dias_financiamiento_alimento }} días</td>
                            <td>{{ round($tasaAplicarAlimento) }}%</td>
                            @php
                                if (! $usaCalculoBreakeven) {
                                    $costoFinancieroAlimento = ($tasaAplicarAlimento / 100) * $costoAlimentacionCab;
                                }
                            @endphp
                            <td>$ {{ number_format($costoFinancieroAlimento,2,',','.') }}</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr class="total-row">
                            <td colspan="5" class="total-label">Costo financiero total</td>
                            <td>$ {{ number_format($usaCalculoBreakeven ? $costoFinancieroTotal : $costoFinancieroHacienda + $costoFinancieroAlimento,2,',','.') }}</td>
                        </tr>
                        <tr class="total-row">
                            <td colspan="5" class="total-label">Utilidad <span class="highlight">antes de impuestos nacionales y provinciales</span> CON costo financiero</td>
                            <td class="highlight" style="text-align: right;">$ {{ number_format($usaCalculoBreakeven ? $utilidadConCostoFinanciero : $utilidadAntesImpuestos - ($costoFinancieroHacienda + $costoFinancieroAlimento),2,',','.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="rp-section">
                <div class="rp-section-header">
                    <span class="rp-section-icon icon-amber">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                    </span>
                    <span class="rp-section-title">Breakeven</span>
                </div>
                <div class="rp-section-body cols-1">
                    <div class="rp-breakeven">
                        <div class="rp-breakeven-item">
                            <button
                                type="button"
                                class="rp-breakeven-btn rp-breakeven-btn--invernada"
                                wire:click="calcularBreakevenInvernada"
                                wire:loading.attr="disabled"
                                wire:target="calcularBreakevenInvernada"
                            >
                                <span wire:loading.remove wire:target="calcularBreakevenInvernada">Breakeven Invernada</span>
                                <span wire:loading wire:target="calcularBreakevenInvernada">Calculando…</span>
                            </button>
                            <div @class([
                                'rp-breakeven-result',
                                'rp-breakeven-result--invernada',
                                'rp-breakeven-result--active' => $breakevenInvernada !== null,
                            ])>
                                @if($breakevenInvernada !== null)
                                    {{ number_format($breakevenInvernada, 2, ',', '.') }}
                                    <span class="rp-unit">$/Kg</span>
                                @else
                                    <span class="rp-breakeven-placeholder">—</span>
                                @endif
                            </div>
                        </div>
    
                        <div class="rp-breakeven-item">
                            <button
                                type="button"
                                class="rp-breakeven-btn rp-breakeven-btn--gordo"
                                wire:click="calcularBreakevenGordo"
                                wire:loading.attr="disabled"
                                wire:target="calcularBreakevenGordo"
                            >
                                <span wire:loading.remove wire:target="calcularBreakevenGordo">Breakeven Gordo</span>
                                <span wire:loading wire:target="calcularBreakevenGordo">Calculando…</span>
                            </button>
                            <div @class([
                                'rp-breakeven-result',
                                'rp-breakeven-result--gordo',
                                'rp-breakeven-result--active' => $breakevenGordo !== null,
                            ])>
                                @if($breakevenGordo !== null)
                                    {{ number_format($breakevenGordo, 2, ',', '.') }}
                                    <span class="rp-unit">$/Kg</span>
                                @else
                                    <span class="rp-breakeven-placeholder">—</span>
                                @endif
                            </div>
                        </div>
    
                        <div class="rp-breakeven-item rp-breakeven-item--reset">
                            <button
                                type="button"
                                class="rp-breakeven-btn rp-breakeven-btn--reset"
                                wire:click="reestablecerBreakeven"
                                wire:loading.attr="disabled"
                                wire:target="reestablecerBreakeven"
                                @disabled($breakevenGordo === null && $breakevenInvernada === null)
                            >
                                <span wire:loading.remove wire:target="reestablecerBreakeven">Reestablecer</span>
                                <span wire:loading wire:target="reestablecerBreakeven">Reestableciendo…</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    @endif

</div>{{-- /reporte-root --}}
</x-filament-widgets::widget>
