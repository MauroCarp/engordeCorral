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
        --c-muted:       #64748b;
        --c-text:        #e2e8f0;
        --c-text-soft:   #94a3b8;
        --c-heading:     #f8fafc;

        --r:  6px;
        --r2: 10px;

        font-family: 'Instrument Sans', sans-serif;
        background: var(--c-bg);
        color: var(--c-text);
        padding: 2rem;
        border-radius: var(--r2);
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
        font-size: 1.05rem;
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
            <div class="rp-eyebrow">Reporte de modelo</div>
            <h2 class="rp-title">Parámetros del Sistema</h2>
            <p class="rp-subtitle">Último modelo registrado · vista consolidada</p>
        </div>
        @if($modelo)
        <div class="rp-meta">
            <span class="rp-badge">
                <span class="rp-badge-dot"></span>
                Registro #{{ $modelo->id }}
            </span>
            @if($modelo->created_at)
            <span class="rp-date">{{ $modelo->created_at->format('d/m/Y — H:i') }}</span>
            @endif
        </div>
        @endif
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
            <div class="rp-section-body">
                <div class="rp-field">
                    <span class="rp-label">Precio venta a faena</span>
                    <span class="rp-value rp-value-accent">
                        {{ number_format($modelo->precio_venta_faena, 1, ',', '.') }}
                        <span class="rp-unit">$/Kg</span>
                    </span>
                </div>
                <div class="rp-field">
                    <span class="rp-label">Precio compra terneras/os destete</span>
                    <span class="rp-value rp-value-accent">
                        {{ number_format($modelo->precio_compra_ternero, 1, ',', '.') }}
                        <span class="rp-unit">$/Kg</span>
                    </span>
                </div>
                <div class="rp-field">
                    <span class="rp-label">Peso neto de entrada</span>
                    <span class="rp-value">
                        {{ number_format($modelo->peso_neto_entrada, 2, ',', '.') }}
                        <span class="rp-unit">Kg</span>
                    </span>
                </div>
                <div class="rp-field">
                    <span class="rp-label">Peso neto venta</span>
                    <span class="rp-value">
                        {{ number_format($modelo->peso_neto_venta, 2, ',', '.') }}
                        <span class="rp-unit">Kg</span>
                    </span>
                </div>
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
                <span class="rp-section-title">Financiero</span>
            </div>
            <div class="rp-section-body">
                <div class="rp-field">
                    <span class="rp-label">Tasa anual</span>
                    <span class="rp-value rp-value-green">
                        {{ number_format($modelo->tasa_anual, 0, ',', '.') }}
                        <span class="rp-unit">%</span>
                    </span>
                </div>
                <div class="rp-field">
                    <span class="rp-label">Plazo compra hacienda</span>
                    <span class="rp-value">
                        {{ number_format($modelo->plazo_compra_hacienda, 0) }}
                        <span class="rp-unit">días</span>
                    </span>
                </div>
                <div class="rp-field">
                    <span class="rp-label">Plazo venta hacienda</span>
                    <span class="rp-value">
                        {{ number_format($modelo->plazo_venta_hacienda, 0) }}
                        <span class="rp-unit">días</span>
                    </span>
                </div>
                <div class="rp-field">
                    <span class="rp-label">Días financiamiento alimento</span>
                    <span class="rp-value">
                        {{ number_format($modelo->dias_financiamiento_alimento, 0) }}
                        <span class="rp-unit">días</span>
                    </span>
                </div>
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
            <div class="rp-section-body" style="grid-template-columns: repeat(4, 1fr)">
                <div class="rp-field">
                    <span class="rp-label">Cabezas/jaula terneros</span>
                    <span class="rp-value">
                        {{ number_format($modelo->cabezas_jaula_terneros, 0) }}
                        <span class="rp-unit">terneros/as</span>
                    </span>
                </div>
                <div class="rp-field">
                    <span class="rp-label">Cabezas/jaula gordos</span>
                    <span class="rp-value">
                        {{ number_format($modelo->cabezas_jaula_gordos, 0) }}
                        <span class="rp-unit">gordos/as</span>
                    </span>
                </div>
                <div class="rp-field">
                    <span class="rp-label">Flete compra</span>
                    <span class="rp-value">
                        {{ number_format($modelo->flete_compra_km, 0, ',', '.') }}
                        <span class="rp-unit">km</span>
                    </span>
                </div>
                <div class="rp-field">
                    <span class="rp-label">Flete venta</span>
                    <span class="rp-value">
                        {{ number_format($modelo->flete_venta_km, 0, ',', '.') }}
                        <span class="rp-unit">km</span>
                    </span>
                </div>
                <div class="rp-field">
                    <span class="rp-label">Flete compra-venta precio</span>
                    <span class="rp-value rp-value-amber">
                        {{ number_format($modelo->flete_compra_venta_precio, 0, ',', '.') }}
                        <span class="rp-unit">$/Kg</span>
                    </span>
                </div>
                <div class="rp-field">
                    <span class="rp-label">Gastos de compra</span>
                    <span class="rp-value">
                        {{ number_format($modelo->gastos_compra, 0, ',', '.') }}
                        <span class="rp-unit">%</span>
                    </span>
                </div>
                <div class="rp-field">
                    <span class="rp-label">Gastos de venta</span>
                    <span class="rp-value">
                        {{ number_format($modelo->gastos_venta, 0, ',', '.') }}
                        <span class="rp-unit">%</span>
                    </span>
                </div>
            </div>
        </div>

        {{-- Sanidad + Nutrición side by side (full width) --}}
        <div class="rp-grid-full">
            <div class="rp-nested">

                {{-- Sanidad --}}
                <div class="rp-section">
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
                    </div>
                    <div class="rp-section-body cols-3">
                        <div class="rp-field">
                            <span class="rp-label">Precio alimento balanceado</span>
                            <span class="rp-value rp-value-accent">
                                {{ number_format($modelo->precio_alimento_balanceado, 1, ',', '.') }}
                                <span class="rp-unit">$/Kg</span>
                            </span>
                        </div>
                        <div class="rp-field">
                            <span class="rp-label">Consumo promedio MS terminación</span>
                            <span class="rp-value">
                                {{ number_format($modelo->consumo_promedio_ms, 1, ',', '.') }}
                                <span class="rp-unit">% PV</span>
                            </span>
                        </div>
                        <div class="rp-field">
                            <span class="rp-label">Eficiencia conversión</span>
                            <span class="rp-value">
                                {{ number_format($modelo->eficiencia_conversion, 1, ',', '.') }}
                                <span class="rp-unit">kg MS/kg carne</span>
                            </span>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>{{-- /rp-grid --}}
    @endif

</div>{{-- /reporte-root --}}
</x-filament-widgets::widget>
