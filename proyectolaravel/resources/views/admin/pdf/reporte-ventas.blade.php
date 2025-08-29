<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Ventas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #059669;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #059669;
            margin: 0;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .stats {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .stat-box {
            border: 1px solid #ddd;
            padding: 15px;
            text-align: center;
            width: 30%;
        }
        .stat-box h3 {
            margin: 0 0 10px 0;
            color: #059669;
            font-size: 14px;
        }
        .stat-box .value {
            font-size: 20px;
            font-weight: bold;
            color: #333;
        }
        .section {
            margin-bottom: 30px;
        }
        .section h2 {
            color: #059669;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #333;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            color: #666;
            font-size: 10px;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Reporte de Ventas</h1>
        <p>Período: {{ $fechaInicio->format('d/m/Y') }} - {{ $fechaFin->format('d/m/Y') }}</p>
        <p>Generado el: {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>

    <div class="stats">
        <div class="stat-box">
            <h3>Total Ventas</h3>
            <div class="value">CRC {{ number_format($totalVentas, 2) }}</div>
        </div>
        <div class="stat-box">
            <h3>Total Pedidos</h3>
            <div class="value">{{ $totalPedidos }}</div>
        </div>
        <div class="stat-box">
            <h3>Ticket Promedio</h3>
            <div class="value">CRC {{ number_format($promedioTicket, 2) }}</div>
        </div>
    </div>

    <div class="section">
        <h2>Detalle de Pedidos</h2>
        <table>
            <thead>
                <tr>
                    <th># Pedido</th>
                    <th>Cliente</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pedidos as $pedido)
                <tr>
                    <td>{{ $pedido->id }}</td>
                    <td>{{ $pedido->user->name ?? 'N/A' }}</td>
                    <td>{{ $pedido->fecha_pedido->format('d/m/Y H:i') }}</td>
                    <td>{{ $pedido->estado }}</td>
                    <td class="text-right">CRC {{ number_format($pedido->total, 2) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">No hay pedidos en este período</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($pedidos->count() > 0)
    <div class="section">
        <h2>Detalle de Productos por Pedido</h2>
        @foreach($pedidos as $pedido)
        <div style="margin-bottom: 20px;">
            <h4 style="color: #059669; margin-bottom: 10px;">
                Pedido #{{ $pedido->id }} - {{ $pedido->user->name ?? 'N/A' }} 
                ({{ $pedido->fecha_pedido->format('d/m/Y') }})
            </h4>
            <table>
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Categoría</th>
                        <th class="text-right">Cantidad</th>
                        <th class="text-right">Precio Unit.</th>
                        <th class="text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pedido->detalles as $detalle)
                    <tr>
                        <td>{{ $detalle->producto->nombre ?? 'N/A' }}</td>
                        <td>{{ $detalle->producto->categoria ?? 'N/A' }}</td>
                        <td class="text-right">{{ $detalle->cantidad }}</td>
                        <td class="text-right">CRC {{ number_format($detalle->precio_unitario, 2) }}</td>
                        <td class="text-right">CRC {{ number_format($detalle->cantidad * $detalle->precio_unitario, 2) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">No hay detalles para este pedido</td>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="text-right"><strong>Total del Pedido:</strong></td>
                        <td class="text-right"><strong>CRC {{ number_format($pedido->total, 2) }}</strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        @endforeach
    </div>
    @endif

    <div class="footer">
        <p>Este reporte fue generado automáticamente por el sistema de administración</p>
        <p>© {{ date('Y') }} - Todos los derechos reservados</p>
    </div>
</body>
</html>
