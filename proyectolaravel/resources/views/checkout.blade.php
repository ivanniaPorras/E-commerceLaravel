@extends('layouts.app')

@section('content')
<section class="py-5" style="background-color: #f4f9f5;">
    <div class="container">
        <h2 class="display-5 fw-bold text-center mb-4" style="color:#388e3c;">Proceso de Compra</h2>
        
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm border-0" style="background-color: #fff;">
                    <div class="card-body p-4">
                        
                        <!-- Resumen de la compra -->
                        <div class="mb-4 p-3" style="background-color: #f8f9fa; border-radius: 8px;">
                            <h5 class="text-success mb-3">Resumen de tu Compra</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-2"><strong>Productos en carrito:</strong></p>
                                    @foreach($carrito as $productoId => $item)
                                        <div class="d-flex justify-content-between mb-1">
                                            <span>{{ $item['nombre'] }} x{{ $item['cantidad'] }}</span>
                                            <span>₡{{ number_format($item['precio'] * $item['cantidad'], 2) }}</span>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="col-md-6">
                                    <div class="border-top pt-2">
                                        <div class="d-flex justify-content-between mb-1">
                                            <span>Subtotal:</span>
                                            <span>₡{{ number_format($subtotal, 2) }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-1">
                                            <span>Impuestos (13%):</span>
                                            <span>₡{{ number_format($impuesto, 2) }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-1">
                                            <span>Envío:</span>
                                            <span>₡{{ number_format($envio, 2) }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between fw-bold text-success">
                                            <span>Total:</span>
                                            <span>₡{{ number_format($total, 2) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <p class="mb-4 text-muted text-center">Completa los campos con tu información para finalizar la compra</p>

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
                                <select name="payment_method" id="payment_method" class="form-select" required>
                                    <option value="credit_card">Tarjeta de Crédito</option>
                                    <option value="paypal">PayPal</option>
                                    <option value="bank_transfer">Transferencia Bancaria</option>
                                </select>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success btn-lg" style="background-color:#4caf50; border:none;">
                                    <i class="bi bi-bag-check"></i> Finalizar Compra
                                </button>
                                <a href="{{ route('carrito.index') }}" class="btn btn-outline-success">
                                    <i class="bi bi-arrow-left"></i> Volver al carrito
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection