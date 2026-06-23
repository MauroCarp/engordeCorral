<div
    {{ $attributes->merge($getExtraAttributes(), escape: false)->class(['dashboard-tabs']) }}
    x-data="{
        activeTab: 0,
        tabCount: 3,
        tabs: ['Reporte del modelo', 'Análisis de costos', 'Sensibilidad de precios'],
        prev() {
            if (this.activeTab > 0) {
                this.activeTab--;
                this.resizeCharts();
            }
        },
        next() {
            if (this.activeTab < this.tabCount - 1) {
                this.activeTab++;
                this.resizeCharts();
            }
        },
        goTo(index) {
            this.activeTab = index;
            this.resizeCharts();
        },
        resizeCharts() {
            this.$nextTick(() => window.dispatchEvent(new Event('resize')));
        },
    }"
>
    <div class="dashboard-tabs__nav">
        <button
            type="button"
            class="dashboard-tabs__arrow"
            x-on:click="prev()"
            x-bind:disabled="activeTab === 0"
            x-bind:class="{ 'dashboard-tabs__arrow--disabled': activeTab === 0 }"
            aria-label="Pestaña anterior"
        >
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M15 18l-6-6 6-6" />
            </svg>
        </button>

        <div class="dashboard-tabs__header">
            <span class="dashboard-tabs__title" x-text="tabs[activeTab]"></span>
            <div class="dashboard-tabs__indicators">
                <template x-for="(tab, index) in tabs" x-bind:key="index">
                    <button
                        type="button"
                        class="dashboard-tabs__indicator"
                        x-bind:class="{ 'dashboard-tabs__indicator--active': activeTab === index }"
                        x-on:click="goTo(index)"
                        x-bind:aria-label="tab"
                    ></button>
                </template>
            </div>
        </div>

        <button
            type="button"
            class="dashboard-tabs__arrow"
            x-on:click="next()"
            x-bind:disabled="activeTab === tabCount - 1"
            x-bind:class="{ 'dashboard-tabs__arrow--disabled': activeTab === tabCount - 1 }"
            aria-label="Pestaña siguiente"
        >
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M9 18l6-6-6-6" />
            </svg>
        </button>
    </div>

    <div class="dashboard-tabs__panels">
        {{ $getChildSchema() }}
    </div>

    <style>
        [x-cloak] {
            display: none !important;
        }

        .dashboard-tabs {
            --dash-bg: #0f1117;
            --dash-surface: #161b27;
            --dash-border: #2a3245;
            --dash-accent: #f59e0b;
            --dash-text: #f8fafc;
            --dash-muted: #94a3b8;
            font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
        }

        .dashboard-tabs__nav {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
            padding: 0.75rem 1rem;
            background: var(--dash-surface);
            border: 1px solid var(--dash-border);
            border-radius: 0.75rem;
        }

        .dashboard-tabs__arrow {
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 0.5rem;
            border: 1px solid var(--dash-border);
            background: var(--dash-bg);
            color: var(--dash-text);
            cursor: pointer;
            transition: background 0.15s, border-color 0.15s, color 0.15s;
        }

        .dashboard-tabs__arrow:hover:not(:disabled) {
            border-color: var(--dash-accent);
            color: var(--dash-accent);
        }

        .dashboard-tabs__arrow svg {
            width: 1.25rem;
            height: 1.25rem;
        }

        .dashboard-tabs__arrow--disabled,
        .dashboard-tabs__arrow:disabled {
            opacity: 0.35;
            cursor: not-allowed;
        }

        .dashboard-tabs__header {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
            min-width: 0;
        }

        .dashboard-tabs__title {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--dash-text);
            text-align: center;
        }

        .dashboard-tabs__indicators {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .dashboard-tabs__indicator {
            width: 0.625rem;
            height: 0.625rem;
            border-radius: 9999px;
            border: none;
            background: var(--dash-border);
            cursor: pointer;
            padding: 0;
            transition: background 0.15s, transform 0.15s;
        }

        .dashboard-tabs__indicator:hover {
            background: var(--dash-muted);
        }

        .dashboard-tabs__indicator--active {
            background: var(--dash-accent);
            transform: scale(1.2);
        }

        .dashboard-tabs__panels {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            min-height: 200px;
        }

        .dashboard-tabs__panel {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .dashboard-widget-group {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
    </style>
</div>
