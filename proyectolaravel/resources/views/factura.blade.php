<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura de Compra</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>
    <script>
        
        // Función para generar un ID de compra único que no se repita
        function generateOrderId() {
            const timestamp = Date.now(); 
            const randomPart = Math.floor(Math.random() * 1000000000);
            const uniqueId = `ORD-${timestamp}-${randomPart}`;
            return uniqueId;
        }

        // Función para obtener la fecha de compra actual en formato adecuado
        function getCurrentDate() {
            const now = new Date();
            const options = { year: 'numeric', month: 'long', day: 'numeric' };
            return now.toLocaleDateString('es-ES', options); 
        }

        // Llenar la fecha de la compra y el ID de compra dinámicamente
        window.onload = function() {
            document.getElementById('order-id').textContent = generateOrderId(); 
            document.getElementById('purchase-date').textContent = getCurrentDate(); 
        };

        // Función para generar el PDF cuando el botón es presionado
        function generatePDF() {
            // Configuración de html2pdf.js
            const element = document.getElementById('invoice-content'); // convertir a PDF
            const opt = {
                margin:       0.5,
                filename:     'factura_compra.pdf',
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  { scale: 4 },
                jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
            };
            
            // Generar el PDF usando html2pdf.js
            html2pdf().from(element).set(opt).save();
        }
    </script>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f9f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .invoice-container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 700px;
            font-size: 14px;
            text-align: center; 
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
            font-size: 24px;
        }

        .invoice-header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #ccc;
            padding-bottom: 10px;
        }

        .invoice-details {
            margin-top: 30px;
        }

        .invoice-details th, .invoice-details td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .invoice-details th {
            background-color: #f0f0f0;
        }

        .total-row {
            font-weight: bold;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            border-top: 2px solid #ccc;
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
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
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
            <p><strong>ID de Compra:</strong> <span id="order-id">Cargando...</span></p>
            <p><strong>Fecha de Compra:</strong> <span id="purchase-date">Cargando...</span></p>
        </div>

        <div class="invoice-details">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Producto A</td>
                        <td>2</td>
                        <td>₡3,000</td>
                        <td>₡6,000</td>
                    </tr>
                    <tr>
                        <td>Producto B</td>
                        <td>1</td>
                        <td>₡5,000</td>
                        <td>₡5,000</td>
                    </tr>
                    <tr>
                        <td>Producto C</td>
                        <td>3</td>
                        <td>₡1,500</td>
                        <td>₡4,500</td>
                    </tr>
                    <tr class="total-row">
                        <td colspan="3" style="text-align: right;">Total Compra:</td>
                        <td>₡15,500</td>
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
