<x-filament-widgets::widget>
    @php
        $formatNumber = static fn (float $value, int $decimals = 4): string => number_format($value, $decimals, ',', '.');
    @endphp

    <x-filament::section>
        <style>
            .nutricion-dieta-widget {
                font-family: 'Instrument Sans', sans-serif;
            }

            .nutricion-dieta-header {
                display: flex;
                align-items: flex-start;
                gap: 1rem;
                margin-bottom: 1rem;
            }

            .nutricion-dieta-title {
                font-size: 1.05rem;
                font-weight: 700;
                margin-bottom: 0.3rem;
            }

            .nutricion-dieta-subtitle {
                color: #94a3b8;
                font-size: 0.85rem;
            }

            .nutricion-dieta-wrap {
                overflow-x: auto;
            }

            .nutricion-dieta-table {
                width: 100%;
                border-collapse: collapse;
            }

            .nutricion-dieta-table th,
            .nutricion-dieta-table td {
                padding: 0.85rem 0.9rem;
                border-bottom: 1px solid rgba(148, 163, 184, 0.18);
                white-space: nowrap;
            }

            .nutricion-dieta-table thead th {
                text-transform: uppercase;
                letter-spacing: 0.06em;
                font-size: 0.78rem;
                color: #94a3b8;
                text-align: right;
            }

            .nutricion-dieta-table thead th:first-child,
            .nutricion-dieta-table td:first-child {
                text-align: left;
            }

            .nutricion-dieta-table tbody td:not(:first-child),
            .nutricion-dieta-table tfoot td:not(:first-child) {
                text-align: right;
                font-family: 'DM Mono', monospace;
            }

            .nutricion-dieta-table tbody tr:hover {
                background: rgba(20, 184, 166, 0.06);
            }

            .nutricion-dieta-table tfoot td {
                border-top: 2px solid rgba(45, 212, 191, 0.3);
                border-bottom: 0;
                font-weight: 700;
                color: #5eead4;
            }

            .nutricion-dieta-empty {
                color: #94a3b8;
                padding: 0.35rem 0;
            }

            @media (max-width: 768px) {
                .nutricion-dieta-header {
                    flex-direction: column;
                }
            }
        </style>

        <div class="nutricion-dieta-widget">
            <div class="nutricion-dieta-header">
                <div>
                    <div class="nutricion-dieta-title">Análisis de Dietas</div>
                    <div class="nutricion-dieta-subtitle">
                        @if ($modelo)
                            Modelo activo: {{ $modelo->nombre }}
                        @else
                            No hay un modelo seleccionado en el panel principal.
                        @endif
                    </div>
                </div>
            </div>

            @if (! $modelo)
                <div class="nutricion-dieta-empty">
                    Seleccioná un modelo desde el admin panel para ver este análisis en Nutrición.
                </div>
            @elseif ($rowCount === 0)
                <div class="nutricion-dieta-empty">
                    El modelo seleccionado no tiene raciones configuradas en la dieta.
                </div>
            @else
                <div class="nutricion-dieta-wrap">
                    <table class="nutricion-dieta-table">
                        <thead>
                            <tr>
                                <th>Dieta</th>
                                <th>Peso Medio</th>
                                <th>Cons MF</th>
                                <th>Consumo TC</th>
                                <th>%MS</th>
                                <th>Consumo MS</th>
                                <th>$/Kg TC</th>
                                <th>$/Kg MS</th>
                                <th>$ Kg/MS/Cab/Dia</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rows as $row)
                                <tr>
                                    <td>{{ $row['dieta'] }}</td>
                                    <td>{{ $formatNumber((float) $row['peso_medio'], 1) }}</td>
                                    <td>{{ $formatNumber((float) $row['cons_mf'], 1) }}</td>
                                    <td>{{ $formatNumber((float) $row['consumo_tc'], 1) }}</td>
                                    <td>{{ $formatNumber((float) $row['porcentaje_ms'], 1) }}%</td>
                                    <td>{{ $formatNumber((float) $row['consumo_ms'], 1) }}</td>
                                    <td>{{ $formatNumber((float) $row['costo_kg_tc'], 2) }}</td>
                                    <td>{{ $formatNumber((float) $row['costo_kg_ms'], 2) }}</td>
                                    <td>{{ $formatNumber((float) $row['costo_kg_ms_cab_dia'], 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td>Promedio</td>
                                <td>{{ $formatNumber((float) $averages['peso_medio'], 1) }}</td>
                                <td>{{ $formatNumber((float) $averages['cons_mf'], 1) }}</td>
                                <td>{{ $formatNumber((float) $averages['consumo_tc'], 1) }}</td>
                                <td>{{ $formatNumber((float) $averages['porcentaje_ms'], 1) }}%</td>
                                <td>{{ $formatNumber((float) $averages['consumo_ms'], 1) }}</td>
                                <td>{{ $formatNumber((float) $averages['costo_kg_tc'], 2) }}</td>
                                <td>{{ $formatNumber((float) $averages['costo_kg_ms'], 2) }}</td>
                                <td>{{ $formatNumber((float) $averages['costo_kg_ms_cab_dia'], 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @endif
        </div>
    </x-filament::section>
</x-filament-widgets::widget>