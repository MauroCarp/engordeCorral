<x-filament-widgets::widget>
    <x-filament::section>
        <style>
            .estructura-costo-root {
                font-family: 'Instrument Sans', sans-serif;
                color: #e2e8f0;
                padding: 0rem 2rem 2rem 2rem;
            }
            .estructura-costo-table {
                width: 100%;
                border-collapse: collapse;
            }
            .estructura-costo-table th {
                text-align: left;
                padding: 1rem;
                color: #ffffff;
                font-weight: bold;
                font-size: 1.25rem;
                border-bottom: 2px solid rgb(161, 161, 161);
            }
            .estructura-costo-table td {
                padding: 0.5rem 0.75rem;
            }
            .estructura-costo-table .label-cell {
                text-align: left;
                font-weight: 600;
            }
            .estructura-costo-table .pct-cell {
                text-align: right;
                font-weight: bold;
                white-space: nowrap;
            }
            .estructura-costo-table .subtotal-pct-cell {
                text-align: right;
                font-weight: bold;
                white-space: nowrap;
                color: #f59e0b;
            }
            .estructura-costo-table .subtotal-money-cell {
                text-align: right;
                font-weight: bold;
                white-space: nowrap;
                color: #f59e0b;
            }
            .estructura-costo-table tbody tr {
                border-bottom: 2px dotted #ffffff55;
            }
            .estructura-costo-table tbody tr:last-child {
                border-bottom: none;
            }
            .estructura-costo-table tfoot tr {
                border-top: 2px solid #ffffff;
            }
            .estructura-costo-table tfoot td {
                font-weight: bold;
                color: #f59e0b;
                font-size: 1.05rem;
            }
            .estructura-costo-table tfoot .label-cell {
                color: #f59e0b;
            }
        </style>

        <div class="estructura-costo-root">
            @if (! $modelo)
                <div style="padding: 1rem 0; color: #94a3b8; font-weight: 600;">
                    No hay un modelo seleccionado para calcular la estructura del costo.
                </div>
            @else
            @php
                $inv     = (float) $valorTerneroInvernada;
                $alim    = (float) $costoAlimentacionCab;
                $san     = (float) $costoSanidadCab;
                $gscom   = (float) $gastoCompraCab + (float) $gastoVentaCab;
                $fletes  = (float) $fleteCompraCab + (float) $fleteVentaCab;
                $estruc  = (float) $costoAmortizacionCab;
                $cab     = max(1, (float) $capacidadEstructura);

                $total   = $inv + $alim + $san + $gscom + $fletes + $estruc;

                $pct = static fn (float $v): float => $total > 0 ? ($v * 100) / $total : 0.0;
                $fmt = static fn (float $v): string => number_format($v, 2, ',', '.');

                $subtotalInvAlim    = $inv + $alim;
                $subtotalInvAlimPct = $pct($subtotalInvAlim);
                $subtotalInvAlimArs = $subtotalInvAlim * $cab;
            @endphp

            <table class="estructura-costo-table">
                <thead>
                    <tr>
                        <th colspan="4">Estructura del costo</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Invernada --}}
                    <tr>
                        <td class="label-cell">Invernada</td>
                        <td class="pct-cell">{{ $fmt($pct($inv)) }}%</td>
                        <td></td>
                        <td></td>
                    </tr>

                    {{-- Alimento + subtotal Invernada+Alimento --}}
                    <tr>
                        <td class="label-cell">Alimento</td>
                        <td class="pct-cell">{{ $fmt($pct($alim)) }}%</td>
                        <td class="subtotal-pct-cell">{{ $fmt($subtotalInvAlimPct) }}%</td>
                        <td class="subtotal-money-cell">$ {{ $fmt($subtotalInvAlimArs) }}</td>
                    </tr>

                    {{-- Sanidad --}}
                    <tr>
                        <td class="label-cell">Sanidad</td>
                        <td class="pct-cell">{{ $fmt($pct($san)) }}%</td>
                        <td></td>
                        <td></td>
                    </tr>

                    {{-- Gastos comercialización --}}
                    <tr>
                        <td class="label-cell">Gs comercialización</td>
                        <td class="pct-cell">{{ $fmt($pct($gscom)) }}%</td>
                        <td></td>
                        <td></td>
                    </tr>

                    {{-- Fletes --}}
                    <tr>
                        <td class="label-cell">Fletes</td>
                        <td class="pct-cell">{{ $fmt($pct($fletes)) }}%</td>
                        <td></td>
                        <td></td>
                    </tr>

                    {{-- Estructura --}}
                    <tr>
                        <td class="label-cell">Estructura</td>
                        <td class="pct-cell">{{ $fmt($pct($estruc)) }}%</td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td class="label-cell">Total Costo</td>
                        <td class="pct-cell" style="color:#f59e0b;">100,00%</td>
                        <td></td>
                        <td class="subtotal-money-cell" style="color:#f59e0b;">$ {{ $fmt($total * $cab) }}</td>
                    </tr>
                </tfoot>
            </table>
            @endif
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
