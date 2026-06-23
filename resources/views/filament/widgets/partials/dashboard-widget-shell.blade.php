@props([
    'showRefresh' => true,
    'loadingTargets' => 'handleModeloSeleccionado, refreshDashboardWidget, refreshDashboardWidgets',
])

<div {{ $attributes->class(['modelo-reporte-loading-host']) }}>
    @include('filament.widgets.partials.modelo-reporte-loading', [
        'targets' => $loadingTargets,
    ])

    @if ($showRefresh)
        @include('filament.widgets.partials.dashboard-widget-toolbar')
    @endif

    {{ $slot }}
</div>
