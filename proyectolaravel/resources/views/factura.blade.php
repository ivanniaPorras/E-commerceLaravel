<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura de Compra</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>
    <script>
        function generatePDF() {
            const element = document.getElementById('invoice-content');
            const opt = {
                margin: 0.5,
                filename: 'factura_compra.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 4 },
                jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
            };
            html2pdf().from(element).set(opt).save();
        }
    </script>

    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f9f5;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        .invoice-container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
            max-width: 800px;
            margin: 0 auto;
        }

        h2 {
            text-align: center;
            color: #388e3c;
            margin-bottom: 20px;
            font-size: 26px;
        }

        .invoice-header {
            text-align: left;
            border-bottom: 2px solid #ddd;
            margin-bottom: 20px;
            padding-bottom: 10px;
        }

        .invoice-details table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .invoice-details th, .invoice-details td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .invoice-details th {
            background-color: #81c784;
            color: white;
        }

        .invoice-details td {
            font-size: 16px;
        }

        .total-row {
            font-weight: bold;
            background-color: #f0f0f0;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            border-top: 2px solid #ddd;
            padding-top: 10px;
        }

        .footer p {
            font-size: 14px;
            color: #666;
        }

        .confirmation {
            background-color: #e8f7e9;
            border: 1px solid #81c784;
            padding: 10px;
            border-radius: 5px;
            margin-top: 20px;
            text-align: center;
            color: #388e3c;
            font-weight: bold;
        }

        .export-button {
            display: block;
            margin: 20px auto 0;
            padding: 12px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .export-button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

    <div class="invoice-container" id="invoice-content">
        <h2>Factura de Compra</h2>
        <div class="invoice-header">
            <h3>Compra Confirmada</h3>
            <p><strong>ID de Compra:</strong> {{ $orderId }}</p>
            <p><strong>Fecha de Compra:</strong> {{ $fechaCompra }}</p>
        </div>

        <div class="invoice-details">
            <table>
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($carrito->productos as $producto)
                        <tr>
                            <td>{{ $producto->nombre }}</td>
                            <td>{{ $producto->pivot->cantidad }}</td>
                            <td>₡{{ number_format($producto->precio, 2) }}</td>
                            <td>₡{{ number_format($producto->pivot->cantidad * $producto->precio, 2) }}</td>
                        </tr>
                    @endforeach
                    <tr class="total-row">
                        <td colspan="3" style="text-align: right;">Subtotal:</td>
                        <td>₡{{ number_format($total, 2) }}</td>
                    </tr>
                    <tr class="total-row">
                        <td colspan="3" style="text-align: right;">Impuestos (13%):</td>
                        <td>₡{{ number_format($impuesto, 2) }}</td>
                    </tr>
                    <tr class="total-row">
                        <td colspan="3" style="text-align: right;">Envío:</td>
                        <td>₡{{ number_format($envio, 2) }}</td>
                    </tr>
                    <tr class="total-row">
                        <td colspan="3" style="text-align: right;">Total con impuestos:</td>
                        <td>₡{{ number_format($totalConImpuesto, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="footer">
            <p><strong>Número de Seguimiento:</strong> ABCD1234567</p>
            <p>Para cualquier consulta, por favor contáctenos al correo <strong>soporte@tienda.com</strong></p>
        </div>

        <div class="confirmation">
            <p>¡Gracias por tu compra! Tu pedido está siendo procesado.</p>
        </div>

        <button class="export-button" onclick="generatePDF()">Exportar a PDF</button>
    </div>

</body>
</html>
