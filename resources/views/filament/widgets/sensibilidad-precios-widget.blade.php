<x-filament-widgets::widget>
<x-filament.widgets.partials.dashboard-widget-shell class="sp-root">

<style>
.sp-root {
    --c-bg:        #0f1117;
    --c-surface:   #161b27;
    --c-surface-2: #1e2535;
    --c-border:    #2a3245;
    --c-text:      #e2e8f0;
    --c-heading:   #f8fafc;
    --c-muted:     #94a3b8;

    font-family: 'Instrument Sans', sans-serif;
    background: var(--c-bg);
    color: var(--c-text);
    padding: 2rem;
    border-radius: 10px;
}

.sp-title {
    text-align: center;
    font-size: 1.15rem;
    font-weight: 700;
    color: #60a5fa;
    margin-bottom: 0.25rem;
}

.sp-subtitle {
    text-align: center;
    font-size: 0.78rem;
    color: var(--c-muted);
    margin-bottom: 1.5rem;
}

.sp-wrap {
    overflow-x: auto;
}

.sp-table {
    border-collapse: collapse;
    font-size: 0.78rem;
    margin: 0 auto;
}

.sp-table th,
.sp-table td {
    border: 1px solid var(--c-border);
    padding: 0.35rem 0.55rem;
    text-align: center;
    white-space: nowrap;
}

/* ── Axis labels ───────────────────────────────────── */
.sp-axis-label {
    font-weight: 600;
    color: var(--c-muted);
    font-size: 0.7rem;
    letter-spacing: 0.05em;
    text-transform: uppercase;
    background: var(--c-surface);
}

.sp-vertical-label {
    writing-mode: vertical-rl;
    text-orientation: mixed;
    transform: rotate(180deg);
    font-weight: 600;
    color: var(--c-muted);
    font-size: 0.7rem;
    letter-spacing: 0.05em;
    text-transform: uppercase;
    background: var(--c-surface);
    text-align: center;
    padding: 0.75rem 0.35rem;
}

/* ── Header cells ──────────────────────────────────── */
.sp-pct-header {
    background: var(--c-surface-2);
    padding: 0.3rem 0.5rem;
}

.sp-price-header {
    background: var(--c-surface-2);
    font-weight: 700;
    font-size: 0.82rem;
    color: var(--c-heading);
    min-width: 82px;
}

.sp-price-header.base-col {
    border: 2px solid #60a5fa;
    color: #93c5fd;
}

/* ── Row label cells ───────────────────────────────── */
.sp-row-pct {
    background: var(--c-surface-2);
    min-width: 96px;
}

.sp-row-price {
    background: var(--c-surface-2);
    font-weight: 700;
    font-size: 0.82rem;
    color: var(--c-heading);
    text-align: right;
    padding-right: 0.75rem;
    min-width: 82px;
}

.sp-row-price.base-row {
    border: 2px solid #60a5fa;
    color: #93c5fd;
}

/* ── Data cells ────────────────────────────────────── */
.sp-cell {
    font-weight: 600;
    font-size: 0.78rem;
    min-width: 82px;
    font-variant-numeric: tabular-nums;
}

.sp-cell.base-cell {
    border: 2px solid #60a5fa !important;
    background: rgba(96, 165, 250, 0.18) !important;
    color: #f8fafc !important;
}

/* ── Editable percentage inputs ────────────────────── */
.sp-pct-input {
    width: 44px;
    background: rgba(255,255,255,0.07);
    border: 1px solid var(--c-border);
    border-radius: 4px;
    color: var(--c-text);
    font-size: 0.78rem;
    text-align: center;
    padding: 2px 3px;
    -moz-appearance: textfield;
    transition: border-color 0.15s;
}

.sp-pct-input::-webkit-outer-spin-button,
.sp-pct-input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

.sp-pct-input:focus {
    outline: none;
    border-color: #60a5fa;
    background: rgba(96, 165, 250, 0.1);
}

/* ── Arrow icons ───────────────────────────────────── */
.sp-arr-green { color: #22c55e; font-size: 0.9em; }
.sp-arr-red   { color: #ef4444; font-size: 0.9em; }
.sp-arr-eq    { color: #60a5fa; font-size: 1.1em; font-weight: 700; }

.sp-arr-eq-button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 28px;
    height: 24px;
    border: 1px solid rgba(96, 165, 250, 0.45);
    border-radius: 4px;
    background: rgba(96, 165, 250, 0.08);
    cursor: pointer;
}

.sp-arr-eq-button:hover {
    background: rgba(96, 165, 250, 0.16);
    border-color: #60a5fa;
}

.sp-pct-unit  { font-size: 0.68rem; color: var(--c-muted); margin-left: 1px; }
</style>

<div class="sp-root">
    <div class="sp-title">Análisis de Sensibilidad al precio de la Invernada y del Gordo</div>
    <div class="sp-subtitle">Tabla correcta para los valores introducidos</div>

    @if(! $this->modelo)
        <p style="color:var(--c-muted);text-align:center;padding:2rem 0;">No hay modelo seleccionado.</p>
    @else
    <div class="sp-wrap">
        <table class="sp-table">

            {{-- ── Fila 1: etiqueta del eje X ─────────────────────────────── --}}
            <thead>
            <tr>
                <th colspan="3" style="border:none;background:transparent;"></th>
                <th class="sp-axis-label" colspan="{{ count($colPcts) }}">Precio gordo ($/Kg)</th>
            </tr>

            {{-- ── Fila 2: inputs de porcentaje de columnas ────────────────── --}}
            <tr>
                <th colspan="3" style="border:none;background:transparent;"></th>
                @foreach($colPcts as $ci => $pct)
                    <th class="sp-pct-header">
                        @php $fpct = (float) $pct; @endphp
                        @if($fpct == 0)
                            <div x-data="{ editing: false }" style="display:inline-flex;align-items:center;gap:2px;">
                                <button
                                    x-show="! editing"
                                    type="button"
                                    class="sp-arr-eq sp-arr-eq-button"
                                    x-on:click="editing = true; $nextTick(() => $refs.input.focus())"
                                    title="Editar porcentaje"
                                >=</button>
                                <input
                                    x-show="editing"
                                    x-ref="input"
                                    type="number"
                                    wire:model.change="colPcts.{{ $ci }}"
                                    wire:change="$refresh"
                                    class="sp-pct-input"
                                    step="1" min="-99" max="99"
                                    x-on:blur="editing = false"
                                >
                                <span x-show="editing" class="sp-pct-unit">%</span>
                            </div>
                        @elseif($fpct > 0)
                            {{-- precio gordo sube = favorable = verde ▲ --}}
                            <span class="sp-arr-green">▲</span>
                            <input type="number"
                                   wire:model.change="colPcts.{{ $ci }}"
                                   wire:change="$refresh"
                                   class="sp-pct-input"
                                   step="1" min="-99" max="99">
                            <span class="sp-pct-unit">%</span>
                        @else
                            {{-- precio gordo baja = desfavorable = rojo ▼ --}}
                            <span class="sp-arr-red">▼</span>
                            <input type="number"
                                   wire:model.change="colPcts.{{ $ci }}"
                                   wire:change="$refresh"
                                   class="sp-pct-input"
                                   step="1" min="-99" max="99">
                            <span class="sp-pct-unit">%</span>
                        @endif
                    </th>
                @endforeach
            </tr>

            {{-- ── Fila 3: precios del gordo calculados ───────────────────── --}}
            <tr>
                <th colspan="3" style="border:none;background:transparent;"></th>
                @foreach($gordoHeaders as $ci => $price)
                    <th class="sp-price-header {{ (float)$colPcts[$ci] == 0 ? 'base-col' : '' }}">
                        {{ number_format($price, 2) }}
                    </th>
                @endforeach
            </tr>
            </thead>

            {{-- ── Filas de datos ──────────────────────────────────────────── --}}
            <tbody>
            @foreach($rowPcts as $ri => $rowPct)
            @php $fRowPct = (float) $rowPct; @endphp
            <tr>
                {{-- Etiqueta vertical del eje Y (sólo en la primera fila) --}}
                @if($loop->first)
                    <td class="sp-vertical-label" rowspan="{{ count($rowPcts) }}">
                        Precio Invernada ($/Kg)
                    </td>
                @endif

                {{-- Input de porcentaje de fila --}}
                <td class="sp-row-pct">
                    @if($fRowPct == 0)
                        <div x-data="{ editing: false }" style="display:inline-flex;align-items:center;gap:2px;">
                            <button
                                x-show="! editing"
                                type="button"
                                class="sp-arr-eq sp-arr-eq-button"
                                x-on:click="editing = true; $nextTick(() => $refs.input.focus())"
                                title="Editar porcentaje"
                            >=</button>
                            <input
                                x-show="editing"
                                x-ref="input"
                                type="number"
                                wire:model.change="rowPcts.{{ $ri }}"
                                wire:change="$refresh"
                                class="sp-pct-input"
                                step="1" min="-99" max="99"
                                x-on:blur="editing = false"
                            >
                            <span x-show="editing" class="sp-pct-unit">%</span>
                        </div>
                    @elseif($fRowPct > 0)
                        {{-- invernada más cara = desfavorable = rojo ▲ --}}
                        <span class="sp-arr-red">▲</span>
                        <input type="number"
                               wire:model.change="rowPcts.{{ $ri }}"
                               wire:change="$refresh"
                               class="sp-pct-input"
                               step="1" min="-99" max="99">
                        <span class="sp-pct-unit">%</span>
                    @else
                        {{-- invernada más barata = favorable = verde ▼ --}}
                        <span class="sp-arr-green">▼</span>
                        <input type="number"
                               wire:model.change="rowPcts.{{ $ri }}"
                               wire:change="$refresh"
                               class="sp-pct-input"
                               step="1" min="-99" max="99">
                        <span class="sp-pct-unit">%</span>
                    @endif
                </td>

                {{-- Precio invernada calculado --}}
                <td class="sp-row-price {{ $fRowPct == 0 ? 'base-row' : '' }}">
                    {{ number_format($invernadaValues[$ri], 2) }}
                </td>

                {{-- Celdas de utilidad (delta respecto al escenario base) --}}
                @foreach(($table[$ri] ?? []) as $ci => $cellValue)
                    @php
                        $isBase  = ($fRowPct == 0 && (float)$colPcts[$ci] == 0);
                        $ratio   = $maxAbs > 0 ? abs($cellValue) / $maxAbs : 0;
                        $alpha   = round(0.15 + 0.75 * $ratio, 3);

                        if ($cellValue > 0) {
                            $txtColor = $ratio > 0.5 ? '#fff' : '#bbf7d0';
                            $bgStyle  = "background:rgba(34,197,94,{$alpha});color:{$txtColor};";
                        } elseif ($cellValue < 0) {
                            $txtColor = $ratio > 0.5 ? '#fff' : '#fecaca';
                            $bgStyle  = "background:rgba(239,68,68,{$alpha});color:{$txtColor};";
                        } else {
                            $bgStyle  = 'background:rgba(255,255,255,0.05);color:#e2e8f0;';
                        }
                    @endphp
                    <td class="sp-cell {{ $isBase ? 'base-cell' : '' }}"
                        style="{{ $isBase ? '' : $bgStyle }}">
                        {{ number_format($cellValue) }}
                    </td>
                @endforeach
            </tr>
            @endforeach
            </tbody>

        </table>
    </div>
    @endif
</x-filament.widgets.partials.dashboard-widget-shell>
</x-filament-widgets::widget>
