@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Proceso de Compra</h2>
        
        <!-- Mensaje informativo -->
        <p>Completa los campos con tu información para finalizar la compra</p>

        <!-- Formulario de pago -->
        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Nombre Completo</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Correo Electrónico</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Dirección de Envío</label>
                <input type="text" name="address" id="address" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="payment_method" class="form-label">Método de Pago</label>
                <select name="payment_method" id="payment_method" class="form-control" required>
                    <option value="credit_card">Tarjeta de Crédito</option>
                    <option value="paypal">PayPal</option>
                    <option value="bank_transfer">Transferencia Bancaria</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Finalizar Compra</button>
        </form>

        <!-- Enlace para regresar al carrito -->
        <a href="{{ route('carrito.index') }}" class="btn btn-primary">Volver al carrito</a>
    </div>
@endsection
