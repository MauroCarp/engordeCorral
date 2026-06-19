<div class="dashboard-widget-toolbar">
    <button
        type="button"
        wire:click="refreshDashboardWidget"
        wire:loading.attr="disabled"
        wire:target="refreshDashboardWidget, handleModeloSeleccionado, refreshDashboardWidgets"
        class="dashboard-widget-refresh-btn"
        title="Actualizar datos del widget"
    >
        <svg
            wire:loading.remove
            wire:target="refreshDashboardWidget"
            class="dashboard-widget-refresh-icon"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            aria-hidden="true"
        >
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v6h6M20 20v-6h-6M5 19a9 9 0 0 0 14-2M19 5a9 9 0 0 0-14 2" />
        </svg>
        <svg
            wire:loading
            wire:target="refreshDashboardWidget"
            class="dashboard-widget-refresh-icon modelo-reporte-loading-spinner"
            viewBox="0 0 24 24"
            fill="none"
            aria-hidden="true"
        >
            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" opacity="0.25" />
            <path d="M12 2a10 10 0 0 1 10 10" stroke="currentColor" stroke-width="3" stroke-linecap="round" />
        </svg>
        <span wire:loading.remove wire:target="refreshDashboardWidget">Actualizar</span>
        <span wire:loading wire:target="refreshDashboardWidget">Actualizando...</span>
    </button>
</div>
