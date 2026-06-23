@props([
    'message' => 'Cargando datos...',
    'targets' => 'handleModeloSeleccionado, refreshDashboardWidget, refreshDashboardWidgets',
])

<div
    wire:loading.delay.short
    wire:target="{{ $targets }}"
    class="modelo-reporte-loading-overlay"
    aria-live="polite"
    aria-busy="true"
>
    <div class="modelo-reporte-loading-content">
        <svg class="modelo-reporte-loading-spinner" viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" opacity="0.25" />
            <path d="M12 2a10 10 0 0 1 10 10" stroke="currentColor" stroke-width="3" stroke-linecap="round" />
        </svg>
        <span class="modelo-reporte-loading-message">{{ $message }}</span>
    </div>
</div>

@once
    <style>
        .modelo-reporte-loading-host {
            position: relative;
            min-height: 4rem;
        }

        .modelo-reporte-loading-overlay {
            position: absolute;
            inset: 0;
            z-index: 20;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: inherit;
            background: rgba(15, 17, 23, 0.72);
            backdrop-filter: blur(2px);
        }

        .modelo-reporte-loading-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.75rem;
            padding: 1rem 1.25rem;
            border-radius: 0.75rem;
            background: rgba(22, 27, 39, 0.95);
            border: 1px solid rgba(42, 50, 69, 0.9);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.35);
        }

        .modelo-reporte-loading-spinner {
            width: 2rem;
            height: 2rem;
            color: #3b82f6;
            animation: modelo-reporte-spin 0.8s linear infinite;
        }

        .modelo-reporte-loading-message {
            font-family: 'Instrument Sans', sans-serif;
            font-size: 0.875rem;
            font-weight: 600;
            color: #e2e8f0;
        }

        .dashboard-widget-toolbar {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 0.75rem;
            position: relative;
            z-index: 21;
        }

        .dashboard-widget-refresh-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.35rem 0.75rem;
            border-radius: 0.5rem;
            border: 1px solid rgba(42, 50, 69, 0.9);
            background: rgba(22, 27, 39, 0.95);
            color: #e2e8f0;
            font-family: 'Instrument Sans', sans-serif;
            font-size: 0.75rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.15s ease, border-color 0.15s ease;
        }

        .dashboard-widget-refresh-btn:hover {
            background: rgba(30, 37, 53, 0.95);
            border-color: rgba(59, 130, 246, 0.6);
        }

        .dashboard-widget-refresh-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .dashboard-widget-refresh-icon {
            width: 0.9rem;
            height: 0.9rem;
        }

        @keyframes modelo-reporte-spin {
            to {
                transform: rotate(360deg);
            }
        }
    </style>
@endonce
