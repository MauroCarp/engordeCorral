<x-filament-widgets::widget>
    <x-filament::section>
        <x-filament.widgets.partials.dashboard-widget-shell>
        @php
            $kgMsCabDia  = (($modelo?->peso_neto_entrada + $modelo?->peso_neto_venta) / 2) * ($modelo?->consumo_promedio_ms ?? 0);
            $kgMvCabDia  = ($dietaAverages['porcentaje_ms'] ?? 0) > 0
                ? $kgMsCabDia / ($dietaAverages['porcentaje_ms'] / 100)
                : 0.0;

            $costoAlimento        = ($kgMvCabDia * ($dietaAverages['costo_kg_tc'] ?? 0)) * ($diasEficiencia ?? 0) * (1 + (($modelo?->mortandad ?? 0) / 2));
            $costoSanidad         = (float) ($costoSanidadCab ?? 0);
            $costoFletes          = (float) ($fleteCompraCab ?? 0) + (float) ($fleteVentaCab ?? 0);
            $costoComercializacion = (float) ($gastoCompraCab ?? 0) + (float) ($gastoVentaCab ?? 0);
            $costoEstructura      = (float) ($costoAmortizacionCab ?? 0);

            $subtotalA = $costoAlimento + $costoSanidad + $costoComercializacion + $costoFletes + $costoEstructura;
            $subtotalB = $costoSanidad + $costoComercializacion + $costoFletes + $costoEstructura;

            $pctA = static fn (float $v): float => $subtotalA > 0 ? round(($v * 100) / $subtotalA, 2) : 0.0;
            $pctB = static fn (float $v): float => $subtotalB > 0 ? round(($v * 100) / $subtotalB, 2) : 0.0;
        @endphp

        <div
            wire:key="costo-engorde-chart-{{ $widgetRefreshKey ?? 0 }}"
            style="font-family: 'Instrument Sans', sans-serif; color: #e2e8f0; padding: 0rem 2rem 2rem 2rem;"
            x-data="{
                chartA: null,
                chartB: null,
                init() {
                    Chart.register(ChartDataLabels);

                    const datalabelsConfig = {
                        color: '#ffffff',
                        font: { size: 13, weight: 'bold', family: 'Instrument Sans, sans-serif' },
                        formatter: function(value) {
                            if (value < 1) return '';
                            return value.toFixed(1).replace('.', ',') + '%';
                        },
                        textShadowBlur: 4,
                        textShadowColor: 'rgba(0,0,0,0.6)',
                    };

                    const tooltipCallback = {
                        callbacks: {
                            label: function(ctx) { return ' ' + ctx.formattedValue + '%'; }
                        }
                    };

                    const legendConfig = {
                        position: 'bottom',
                        labels: {
                            color: '#e2e8f0',
                            font: { size: 12, family: 'Instrument Sans, sans-serif' },
                            padding: 14,
                            usePointStyle: true,
                            pointStyle: 'circle',
                        },
                    };

                    // Chart A – con Alimento
                    this.chartA = new Chart(this.$refs.canvasA.getContext('2d'), {
                        type: 'doughnut',
                        data: {
                            labels: @js(['Alimento', 'Sanidad', 'Gs. Comercialización', 'Fletes', 'Estructura']),
                            datasets: [{
                                data: @js([$pctA($costoAlimento), $pctA($costoSanidad), $pctA($costoComercializacion), $pctA($costoFletes), $pctA($costoEstructura)]),
                                backgroundColor: [
                                    'rgba(59, 130, 246, 0.85)',
                                    'rgba(239, 68, 68, 0.85)',
                                    'rgba(245, 158, 11, 0.85)',
                                    'rgba(20, 184, 166, 0.85)',
                                    'rgba(168, 85, 247, 0.85)',
                                ],
                                borderColor: [
                                    'rgba(59, 130, 246, 1)',
                                    'rgba(239, 68, 68, 1)',
                                    'rgba(245, 158, 11, 1)',
                                    'rgba(20, 184, 166, 1)',
                                    'rgba(168, 85, 247, 1)',
                                ],
                                borderWidth: 2,
                                hoverOffset: 8,
                            }],
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            cutout: '60%',
                            plugins: { legend: legendConfig, tooltip: tooltipCallback, datalabels: datalabelsConfig },
                        },
                    });

                    // Chart B – sin Alimento
                    this.chartB = new Chart(this.$refs.canvasB.getContext('2d'), {
                        type: 'doughnut',
                        data: {
                            labels: @js(['Sanidad', 'Gs. Comercialización', 'Fletes', 'Estructura']),
                            datasets: [{
                                data: @js([$pctB($costoSanidad), $pctB($costoComercializacion), $pctB($costoFletes), $pctB($costoEstructura)]),
                                backgroundColor: [
                                    'rgba(239, 68, 68, 0.85)',
                                    'rgba(245, 158, 11, 0.85)',
                                    'rgba(20, 184, 166, 0.85)',
                                    'rgba(168, 85, 247, 0.85)',
                                ],
                                borderColor: [
                                    'rgba(239, 68, 68, 1)',
                                    'rgba(245, 158, 11, 1)',
                                    'rgba(20, 184, 166, 1)',
                                    'rgba(168, 85, 247, 1)',
                                ],
                                borderWidth: 2,
                                hoverOffset: 8,
                            }],
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            cutout: '60%',
                            plugins: { legend: legendConfig, tooltip: tooltipCallback, datalabels: datalabelsConfig },
                        },
                    });
                },
            }"
        >
            @if (! $modelo)
                <div style="padding: 1rem 0; font-weight: 600; color: #94a3b8;">
                    No hay un modelo seleccionado para calcular el costo de engorde.
                </div>
            @else
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2.5rem;">
                    {{-- Chart A --}}
                    <div>
                        <h2 style="font-size: 1.1rem; font-weight: 700; color: #f8fafc; margin-bottom: 1rem; text-align: center;">
                            Costo de engorde con Alimento
                        </h2>
                        <div style="position: relative; height: 300px;">
                            <canvas x-ref="canvasA"></canvas>
                        </div>
                    </div>

                    {{-- Chart B --}}
                    <div>
                        <h2 style="font-size: 1.1rem; font-weight: 700; color: #f8fafc; margin-bottom: 1rem; text-align: center;">
                            Costo de engorde sin Alimento
                        </h2>
                        <div style="position: relative; height: 300px;">
                            <canvas x-ref="canvasB"></canvas>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        </x-filament.widgets.partials.dashboard-widget-shell>
    </x-filament::section>
</x-filament-widgets::widget>

@assets
<script src="https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2/dist/chartjs-plugin-datalabels.min.js"></script>
@endassets
