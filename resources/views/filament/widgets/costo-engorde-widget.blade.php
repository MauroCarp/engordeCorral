<x-filament-widgets::widget>
    <x-filament::section>
        <style>
            .costo-engorde-table {
                width: 100%;
                border-collapse: collapse;
            }
            .costo-engorde-table th, .costo-engorde-table td {
                padding: 0.75rem;
                text-align: left;
                border-bottom: 1px solid #e5e7eb;
            }
            .costo-engorde-table th {
                font-weight: bold;
                color: #ffffff;
            }
            .costo-engorde-table .header-row th {
                border-bottom: 1px solid #e5e7eb;
            }
            .costo-engorde-table .subtotal-row td {
                font-weight: bold;
                border-top: 3px solid #c2c2c2;
            }
            .costo-engorde-table td:not(:first-child), .costo-engorde-table th:not(:first-child) {
                text-align: right;
            }
        </style>
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
                <tr>
                    <td>Alimento</td>
                    <td>433.356,0 $/cab.</td>
                    <td>68,70%</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Sanidad</td>
                    <td>7.145 $/cab.</td>
                    <td>1,13%</td>
                    <td>3,62%</td>
                </tr>
                <tr>
                    <td>Gs Comercializaion</td>
                    <td>91.072,8 $/cab.</td>
                    <td>14,44%</td>
                    <td>46,12%</td>
                </tr>
                <tr>
                    <td>Flets</td>
                    <td>39.727,18</td>
                    <td>6,30%</td>
                    <td>20,12%</td>
                </tr>
                <tr>
                    <td>Estructura</td>
                    <td>59.515 $/cab.</td>
                    <td>9,43%</td>
                    <td>30,14%</td>
                </tr>
            </tbody>
            <tfoot>
                <tr class="subtotal-row">
                    <td>Subtotal A gastos C/aliment.</td>
                    <td>630.815,6 $/cab.</td>
                    <td>100,00%</td>
                    <td></td>
                </tr>
                <tr class="subtotal-row">
                    <td>Subtotal B costos S/aliment.</td>
                    <td>197.459,6 $/cab.</td>
                    <td></td>
                    <td>100,00%</td>
                </tr>
            </tfoot>
        </table>
    </x-filament::section>
</x-filament-widgets::widget>
