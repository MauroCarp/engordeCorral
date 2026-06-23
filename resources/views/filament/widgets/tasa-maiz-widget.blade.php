<x-filament-widgets::widget>
    @php
        $widgetId = 'tasa-maiz-widget-' . str_replace('.', '-', $this->getId());
        $formatNumber = static fn (float $value, int $decimals = 4): string => number_format($value, $decimals, ',', '.');
    @endphp

    <x-filament::section>
        <x-filament.widgets.partials.dashboard-widget-shell class="tasa-maiz-root">
        <style>
            .tasa-maiz-root {
                font-family: 'Instrument Sans', sans-serif;
            }

            .tasa-maiz-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 1rem;
                margin-bottom: 1rem;
            }

            .tasa-maiz-title {
                font-size: 1.2rem;
                font-weight: 700;
                color: #f8fafc;
            }

            .tasa-maiz-meta {
                font-size: 0.95rem;
                font-weight: 600;
                color: #f59e0b;
                text-align: right;
            }

            .tasa-maiz-table {
                width: 100%;
                border-collapse: collapse;
            }

            .tasa-maiz-table th,
            .tasa-maiz-table td {
                padding: 0.85rem 0.9rem;
                border-bottom: 1px solid rgba(255, 255, 255, 0.12);
            }

            .tasa-maiz-table thead th {
                font-size: 0.78rem;
                letter-spacing: 0.08em;
                text-transform: uppercase;
                color: #cbd5e1;
                text-align: right;
            }

            .tasa-maiz-table thead th:first-child,
            .tasa-maiz-table td:first-child {
                text-align: left;
            }

            .tasa-maiz-table tbody td:not(:first-child),
            .tasa-maiz-table tfoot td:not(:first-child) {
                text-align: right;
                font-family: 'DM Mono', monospace;
            }

            .tasa-maiz-label {
                display: inline-flex;
                align-items: center;
                gap: 0.65rem;
                font-weight: 600;
                color: #f8fafc;
            }

            .tasa-maiz-check {
                width: 1rem;
                height: 1rem;
                accent-color: #f59e0b;
                cursor: pointer;
            }

            .tasa-maiz-muted {
                color: #cbd5e1;
            }

            .tasa-maiz-table tfoot td {
                border-top: 2px solid rgba(245, 158, 11, 0.65);
                border-bottom: 0;
                font-weight: 700;
                color: #f59e0b;
            }

            .tasa-maiz-empty {
                color: #cbd5e1;
                text-align: center;
                padding: 1rem 0;
            }

            @media (max-width: 768px) {
                .tasa-maiz-header {
                    flex-direction: column;
                    align-items: flex-start;
                }

                .tasa-maiz-meta {
                    text-align: left;
                }

                .tasa-maiz-table th,
                .tasa-maiz-table td {
                    padding-inline: 0.55rem;
                }
            }
        </style>

        <div
            wire:key="tasa-maiz-content-{{ $widgetRefreshKey ?? 0 }}"
            class="tasa-maiz-root"
            id="{{ $widgetId }}"
            x-data="{
                rows: {{ Illuminate\Support\Js::from($rows) }},
                formatNumber(value, decimals = 4) {
                    const safeValue = Number.isFinite(Number(value)) ? Number(value) : 0;

                    return new Intl.NumberFormat('es-AR', {
                        minimumFractionDigits: decimals,
                        maximumFractionDigits: decimals,
                    }).format(safeValue);
                },
                activeRows() {
                    return this.rows.filter((row) => row.kind === 'data' && row.checked);
                },
                sumColumn2() {
                    return this.activeRows().reduce((carry, row) => carry + Number(row.column2 || 0), 0);
                },
                sumColumn3() {
                    return this.activeRows().reduce((carry, row) => carry + Number(row.column3 || 0), 0);
                },
                percentage(row) {
                    const sum = this.sumColumn3();

                    if (row.kind !== 'data' || !row.checked || sum <= 0) {
                        return 0;
                    }

                    return (Number(row.column3 || 0) * 100) / sum;
                },
                totalPercentage() {
                    return this.activeRows().length > 0 ? 100 : 0;
                },
            }"
        >
            @if (! $modelo)
                <div class="tasa-maiz-empty">No hay modelo disponible para calcular la tasa maiz.</div>
            @else
                <div class="tasa-maiz-header">
                    <div class="tasa-maiz-title">TASA MAIZ</div>
                    <div class="tasa-maiz-meta">
                        Kg Producidos: {{ $formatNumber($kgProducidos, 2) }}
                    </div>
                </div>

                <table class="tasa-maiz-table">
                    <tbody>
                        @foreach ($rows as $row)
                            <tr
                            >
                                <td>
                                    <label class="tasa-maiz-label">
                                        @if ($row['selectable'])
                                            <input
                                                class="tasa-maiz-check"
                                                type="checkbox"
                                                x-model="rows[{{ $loop->index }}].checked"
                                            >
                                        @endif
                                        <span>{{ $row['label'] }}</span>
                                    </label>
                                </td>
                                <td>
                                    @if ($row['kind'] === 'info')
                                        {{ $formatNumber((float) $row['column2'], 2) }}
                                    @else
                                        {{ $formatNumber((float) $row['column2']) }}
                                    @endif
                                </td>
                                <td class="tasa-maiz-muted" data-col3-display>
                                    @if ($row['kind'] === 'info')
                                        {{ $row['column3_label'] }}
                                    @else
                                        {{ $formatNumber((float) $row['column3']) }}
                                    @endif
                                </td>
                                <td class="tasa-maiz-muted" data-col4-display>
                                    @if ($row['kind'] === 'info')
                                        {{ $row['column4_label'] }}
                                    @else
                                        <span x-text="formatNumber(percentage(rows[{{ $loop->index }}]), 2) + '%'"></span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td>Totales</td>
                            <td data-total-col2 x-text="formatNumber(sumColumn2(),2)">{{ $formatNumber($totals['column2'],2) }}</td>
                            <td data-total-col3 x-text="formatNumber(sumColumn3(),2)">{{ $formatNumber($totals['column3'],2) }}</td>
                            <td data-total-col4 x-text="formatNumber(totalPercentage(), 2) + '%'">{{ $formatNumber($totals['column4'], 2) }}%</td>
                        </tr>
                    </tfoot>
                </table>
            @endif
        </div>
        </x-filament.widgets.partials.dashboard-widget-shell>
    </x-filament::section>
</x-filament-widgets::widget>