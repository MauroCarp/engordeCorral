<x-filament-widgets::widget>
    <x-filament::section>
        <div
            style="font-family: 'Instrument Sans', sans-serif; color: #e2e8f0; padding: 0rem 2rem 2rem 2rem;"
            x-data="{
                chart: null,
                init() {
                    Chart.register(ChartDataLabels);
                    const ctx = this.$refs.canvas.getContext('2d');
                    this.chart = new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: @js([
                                'Compra invernada',
                                'Alimentación',
                                'Comercialización',
                                'Estructura',
                                'Sanidad e identificación',
                            ]),
                            datasets: [{
                                data: @js([
                                    round($impactoCompraInvernadaPct, 2),
                                    round($impactoAlimentacionPct, 2),
                                    round($impactoComercializacionPct, 2),
                                    round($impactoEstructuraPct, 2),
                                    round($impactoSanidadPct, 2),
                                ]),
                                backgroundColor: [
                                    'rgba(59, 130, 246, 0.85)',
                                    'rgba(34, 197, 94, 0.85)',
                                    'rgba(245, 158, 11, 0.85)',
                                    'rgba(168, 85, 247, 0.85)',
                                    'rgba(239, 68, 68, 0.85)',
                                ],
                                borderColor: [
                                    'rgba(59, 130, 246, 1)',
                                    'rgba(34, 197, 94, 1)',
                                    'rgba(245, 158, 11, 1)',
                                    'rgba(168, 85, 247, 1)',
                                    'rgba(239, 68, 68, 1)',
                                ],
                                borderWidth: 2,
                                hoverOffset: 8,
                            }],
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            cutout: '62%',
                            plugins: {
                                legend: {
                                    position: 'right',
                                    labels: {
                                        color: '#e2e8f0',
                                        font: { size: 13, family: 'Instrument Sans, sans-serif' },
                                        padding: 16,
                                        usePointStyle: true,
                                        pointStyle: 'circle',
                                    },
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(ctx) {
                                            return ' ' + ctx.formattedValue + '%';
                                        },
                                    },
                                },
                                datalabels: {
                                    color: '#ffffff',
                                    font: { size: 13, weight: 'bold', family: 'Instrument Sans, sans-serif' },
                                    formatter: function(value) {
                                        if (value < 1) return '';
                                        return value.toFixed(1).replace('.', ',') + '%';
                                    },
                                    textShadowBlur: 4,
                                    textShadowColor: 'rgba(0,0,0,0.6)',
                                },
                            },
                        },
                    });
                },
            }"
        >
            @if (! $modelo)
                <div style="padding: 1rem 0; font-weight: 600; color: #94a3b8;">
                    No hay un modelo seleccionado para calcular el impacto.
                </div>
            @else
                <h2 style="font-size: 1.25rem; font-weight: 700; color: #f8fafc; margin-bottom: 1.5rem;">
                    Impacto de los costos sobre el valor del Gordo
                </h2>
                <div style="position: relative; height: 320px;">
                    <canvas x-ref="canvas"></canvas>
                </div>
            @endif
        </div>

    </x-filament::section>
</x-filament-widgets::widget>

@assets
<script src="https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2/dist/chartjs-plugin-datalabels.min.js"></script>
@endassets
