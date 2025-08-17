<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pasarela de Pago</title>
    <script src="https://js.stripe.com/v3/"></script>
    <style>
        /* Estilos */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f9f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .payment-container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input, select {
            width: 100%;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
            font-size: 16px;
        }

        #card-element {
            background-color: #f5f5f5;
            padding: 10px;
            border-radius: 4px;
        }

        #card-errors {
            color: red;
            margin-top: 10px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #4caf50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 20px;
            font-size: 16px;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

    <div class="payment-container">
        <h2>Formulario de Pago</h2>

        <form id="payment-form">
            <!-- Numero de la tarjeta-->
            <div class="form-group">
                <label for="card-element">Número de Tarjeta</label>
                <input type="text" id="card-element" placeholder="Número de Tarjeta" required />
            </div>

            <!-- Banco -->
            <div class="form-group">
                <label for="bank">Banco</label>
                <select id="bank" required>
                    <option value="">Selecciona un banco</option>
                    <option value="banco1">BCR</option>
                    <option value="banco2">Nacional</option>
                    <option value="banco3">BAC</option>
                </select>
            </div>

            <!-- Vencimiento -->
            <div class="form-group">
                <label for="expiry-date">Vencimiento</label>
                <input type="month" id="expiry-date" required />
            </div>

            <!-- CVV -->
            <div class="form-group">
                <label for="cvv">CVV</label>
                <input type="text" id="cvv" placeholder="Número de seguridad" required />
            </div>

            <div id="card-errors" role="alert"></div>

            <button type="button" id="submit" onclick="validarFormulario()">Pagar</button>
        </form>
    </div>

    <script type="text/javascript">
        // Función para validar los campos antes de redirigir
        function validarFormulario() {
            // Obtener los valores de los campos
            var tarjeta = document.getElementById("card-element").value;
            var banco = document.getElementById("bank").value;
            var vencimiento = document.getElementById("expiry-date").value;
            var cvv = document.getElementById("cvv").value;

            // Validar que todos los campos estén completos
            if (tarjeta && banco && vencimiento && cvv) {
                window.location.href = "{{ url('factura') }}";
            } else {
                alert("Por favor, completa todos los campos.");
            }
        }
    </script>

</body>
</html>
