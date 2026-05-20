<x-filament-widgets::widget>
    <x-filament::section>
        @php
            $formatMoney = static fn (float $value): string => number_format($value, 2, ',', '.');
            $formatPercent = static fn (float $value): string => number_format($value, 2, ',', '.') . '%';
            $kgMsCabDia = (($modelo->peso_neto_entrada + $modelo->peso_neto_venta) / 2) * $modelo->consumo_promedio_ms;
            
            $kgMvCabDia = (float) ($kgMsCabDia / ($dietaAverages['porcentaje_ms'] / 100) ?? 0);

            $costoAlimento = ($kgMvCabDia * $dietaAverages['costo_kg_tc']) * $diasEficiencia * (1 + ($modelo->mortandad / 2));
            $costoSanidad = (float) ($costoSanidadCab ?? 0);
            $costoFletes = (float) ($fleteCompraCab ?? 0) + (float) ($fleteVentaCab ?? 0);
            $costoComercializacion = (float) ($gastoCompraCab ?? 0) + (float) ($gastoVentaCab ?? 0);
            $costoEstructura = (float) ($costoAmortizacionCab ?? 0);

            $subtotalA = $costoAlimento + $costoSanidad + $costoComercializacion + $costoFletes + $costoEstructura;
            $subtotalB = $costoSanidad + $costoComercializacion + $costoFletes + $costoEstructura;

            $rows = [
                [
                    'label' => 'Alimento',
                    'value' => $costoAlimento,
                    'percentA' => $subtotalA > 0 ? ($costoAlimento * 100) / $subtotalA : 0,
                    'percentB' => null,
                ],
                [
                    'label' => 'Sanidad',
                    'value' => $costoSanidad,
                    'percentA' => $subtotalA > 0 ? ($costoSanidad * 100) / $subtotalA : 0,
                    'percentB' => $subtotalB > 0 ? ($costoSanidad * 100) / $subtotalB : 0,
                ],
                [
                    'label' => 'Gs Comercialización',
                    'value' => $costoComercializacion,
                    'percentA' => $subtotalA > 0 ? ($costoComercializacion * 100) / $subtotalA : 0,
                    'percentB' => $subtotalB > 0 ? ($costoComercializacion * 100) / $subtotalB : 0,
                ],
                [
                    'label' => 'Fletes',
                    'value' => $costoFletes,
                    'percentA' => $subtotalA > 0 ? ($costoFletes * 100) / $subtotalA : 0,
                    'percentB' => $subtotalB > 0 ? ($costoFletes * 100) / $subtotalB : 0,
                ],
                [
                    'label' => 'Estructura',
                    'value' => $costoEstructura,
                    'percentA' => $subtotalA > 0 ? ($costoEstructura * 100) / $subtotalA : 0,
                    'percentB' => $subtotalB > 0 ? ($costoEstructura * 100) / $subtotalB : 0,
                ],
            ];
        @endphp
        <style>
            .costo-engorde-table {
                width: 100%;
                border-collapse: collapse;
                 font-family: 'Instrument Sans', sans-serif;

            }
            .costo-engorde-table th, .costo-engorde-table td {
                padding: 0.75rem;
                text-align: left;
                border-bottom: 1px solid #e5e7eb;
            }
            .costo-engorde-table th {
                font-weight: bold;
                color: #d4d4d4;
                font-size:1.25rem;
            }
            .costo-engorde-table .header-row th {
                border-bottom: 2px solid rgb(219, 219, 219);
            }
            .costo-engorde-table .subtotal-row td {
                font-weight: bold;
                border-top: 2px solid rgb(233, 233, 233);
                color:#f59e0b;
            }
            .costo-engorde-table td:not(:first-child), .costo-engorde-table th:not(:first-child) {
                text-align: right;
            }
            .costo-engorde-table td:first-child, .costo-engorde-table th:first-child {
                font-weight: bold;
            }
        </style>
        @if (! $modelo)
            <div style="color: #94a3b8; font-family: 'Instrument Sans', sans-serif;">
                Seleccioná un modelo en el panel principal para ver el costo de engorde.
            </div>
        @else
            <table class="costo-engorde-table">
                <thead>
                    <tr class="header-row">
                        <th>Costo de engorde</th>
                        <th></th>
                        <th>% A</th>
                        <th>% B</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rows as $row)
                        <tr>
                            <td>{{ $row['label'] }}</td>
                            <td>{{ $formatMoney((float) $row['value']) }} $/cab.</td>
                            <td>{{ $formatPercent((float) $row['percentA']) }}</td>
                            <td>
                                @if ($row['percentB'] === null)
                                    
                                @else
                                    {{ $formatPercent((float) $row['percentB']) }}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="subtotal-row">
                        <td>Subtotal A gastos C/aliment.</td>
                        <td>{{ $formatMoney($subtotalA) }} $/cab.</td>
                        <td>{{ $formatPercent(100) }}</td>
                        <td></td>
                    </tr>
                    <tr class="subtotal-row">
                        <td>Subtotal B costos S/aliment.</td>
                        <td>{{ $formatMoney($subtotalB) }} $/cab.</td>
                        <td></td>
                        <td>{{ $formatPercent(100) }}</td>
                    </tr>
                </tfoot>
            </table>
        @endif
    </x-filament::section>
</x-filament-widgets::widget>
