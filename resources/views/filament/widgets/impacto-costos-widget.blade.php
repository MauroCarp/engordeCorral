<x-filament-widgets::widget>
    <x-filament::section>
        <style>
            .impact-table {
                width: 100%;
                border-collapse: collapse;
            }
            .impact-table th {
                text-align: center;
                padding: 0.5rem;
                color: #008080;
                font-weight: bold;
                border-bottom: 2px solid black;
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
                border-bottom: 2px dotted #22c55e;
            }
            .impact-table tbody tr:last-child {
                border-bottom: 2px solid #22c55e;
            }
        </style>
        <table class="impact-table">
            <thead>
                <tr>
                    <th colspan="2">Impacto de los costos sobre el valor del Gordo</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="label-cell">Compra invernada</td>
                    <td class="value-cell">53,2%</td>
                </tr>
                <tr>
                    <td class="label-cell">Alimentación</td>
                    <td class="value-cell">22,2%</td>
                </tr>
                <tr>
                    <td class="label-cell">Gastos de comercialización</td>
                    <td class="value-cell">6,7%</td>
                </tr>
                <tr>
                    <td class="label-cell">Gastos de estructura</td>
                    <td class="value-cell">3,0%</td>
                </tr>
                <tr>
                    <td class="label-cell">Sanidad e identificación</td>
                    <td class="value-cell">0,4%</td>
                </tr>
            </tbody>
        </table>
    </x-filament::section>
</x-filament-widgets::widget>
