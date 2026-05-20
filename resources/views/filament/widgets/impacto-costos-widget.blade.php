<x-filament-widgets::widget>
    <x-filament::section>
        <style>
            .impacto-root {
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
                /* background: var(--c-bg); */
                color: var(--c-text);
                padding: 0rem 2rem 2rem 2rem;
                border-radius: var(--r2);
            }
            .impact-table {
                width: 100%;
                border-collapse: collapse;
            }
            .impact-table th {
                text-align: left;
                padding: 1rem;
                color: #ffffff;
                font-weight: bold;
                font-size: 1.25rem;
                border-bottom: 2px solid rgb(161, 161, 161);
            }
            .impact-table td {
                padding: 0.5rem;
            }
            .impact-table .label-cell {
                text-align: left;
            }
            .impact-table .value-cell {
                text-align: right;
                font-weight: bold;
            }
            .impact-table tbody tr {
                border-bottom: 2px dotted #ffffff;
            }
            .impact-table tbody tr:last-child {
                border-bottom: 2px solid #ffffff;
            }
            .impact-table td:first-child, .impact-table th:first-child {
                font-weight: bold;
            }
        </style>
        <div class="impacto-root">
            @if (! $modelo)
                <div style="padding: 1rem 0; color: var(--c-text-soft); font-weight: 600;">
                    No hay un modelo seleccionado para calcular el impacto.
                </div>
            @else
            <table class="impact-table">
                <thead>
                    <tr>
                        <th colspan="2">Impacto de los costos sobre el valor del Gordo</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="label-cell">Compra invernada</td>
                        <td class="value-cell">{{ number_format($impactoCompraInvernadaPct, 1, ',', '.') }}%</td>
                    </tr>
                    <tr>
                        <td class="label-cell">Alimentación</td>
                        <td class="value-cell">{{ number_format($impactoAlimentacionPct, 1, ',', '.') }}%</td>
                    </tr>
                    <tr>
                        <td class="label-cell">Gastos de comercialización</td>
                        <td class="value-cell">{{ number_format($impactoComercializacionPct, 1, ',', '.') }}%</td>
                    </tr>
                    <tr>
                        <td class="label-cell">Gastos de estructura</td>
                        <td class="value-cell">{{ number_format($impactoEstructuraPct, 1, ',', '.') }}%</td>
                    </tr>
                    <tr>
                        <td class="label-cell">Sanidad e identificación</td>
                        <td class="value-cell">{{ number_format($impactoSanidadPct, 1, ',', '.') }}%</td>
                    </tr>
                </tbody>
            </table>
            @endif
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
