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
            font-family: 'Arial', sans-serif;
            background-color: #f4f9f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .payment-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            font-size: 16px;
        }

        h2 {
            text-align: center;
            color: #388e3c;
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
            padding: 12px;
            border-radius: 4px;
            border: 1px solid #ccc;
            font-size: 16px;
        }

        #card-element {
            background-color: #f5f5f5;
            padding: 10px;
            border-radius: 4px;
            font-size: 16px;
        }

        #card-errors {
            color: red;
            margin-top: 10px;
            font-size: 14px;
        }

        button {
            width: 100%;
            padding: 12px;
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

        .form-error {
            color: red;
            font-size: 14px;
            margin-top: 5px;
        }

    </style>
</head>
<body>

    <div class="payment-container">
        <h2>Formulario de Pago</h2>

        <form id="payment-form" onsubmit="return validarFormulario(event)">
            <!-- Numero de la tarjeta-->
            <div class="form-group">
                <label for="card-element">Número de Tarjeta</label>
                <input type="text" id="card-element" placeholder="Número de Tarjeta" maxlength="18" required />
                <div id="card-errors" class="form-error"></div>
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
                <div id="expiry-errors" class="form-error"></div>
            </div>

            <!-- CVV -->
            <div class="form-group">
                <label for="cvv">CVV</label>
                <input type="text" id="cvv" placeholder="Número de seguridad" maxlength="6" required />
                <div id="cvv-errors" class="form-error"></div>
            </div>

            <button type="submit" id="submit">Pagar</button>
        </form>
    </div>

    <script type="text/javascript">
        // Validación de los campos
        function validarFormulario(event) {
            event.preventDefault(); // Prevenir el envío del formulario por defecto

            // Obtener los valores de los campos
            var tarjeta = document.getElementById("card-element").value;
            var banco = document.getElementById("bank").value;
            var vencimiento = document.getElementById("expiry-date").value;
            var cvv = document.getElementById("cvv").value;

            // Limpiar mensajes de error
            document.getElementById("card-errors").textContent = "";
            document.getElementById("expiry-errors").textContent = "";
            document.getElementById("cvv-errors").textContent = "";

            // Validar el número de tarjeta
            if (tarjeta.length < 16 || tarjeta.length > 18) {
                document.getElementById("card-errors").textContent = "El número de tarjeta debe tener entre 16 y 18 dígitos.";
                return false;
            }

            // Validar que la fecha de vencimiento no sea anterior a la fecha actual
            var fechaActual = new Date();
            var [anio, mes] = vencimiento.split('-');
            var fechaVencimiento = new Date(anio, mes - 1);
            if (fechaVencimiento < fechaActual) {
                document.getElementById("expiry-errors").textContent = "La fecha de vencimiento no puede ser anterior a la fecha actual.";
                return false;
            }

            // Validar el CVV (permitiendo hasta 6 dígitos, pero típicamente 3-4)
            if (cvv.length < 3 || cvv.length > 6) {
                document.getElementById("cvv-errors").textContent = "El CVV debe tener entre 3 y 6 dígitos.";
                return false;
            }

            // Si todos los campos son válidos, redirigir a la página de la factura
            window.location.href = "{{ url('factura') }}";
        }
    </script>

</body>
</html>
