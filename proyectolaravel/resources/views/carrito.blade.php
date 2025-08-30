@extends('layouts.app')

@section('content')
<section class="py-5" style="background-color: #f4f9f5;">
    <div class="container">
        <h2 class="display-5 fw-bold text-center mb-4" style="color:#388e3c;">Carrito de Compras</h2>

        @if($carrito->productos->isEmpty())
            <div class="alert alert-info text-center">
                Tu carrito está vacío. <a href="{{ url('/') }}" class="btn btn-success ms-2">Ver productos</a>
            </div>
        @else
        <div class="table-responsive mb-4">
            <table class="table align-middle table-bordered shadow-sm rounded" style="background-color: #fff;">
                <thead>
                    <tr style="background-color:#81c784; color:#fff;">
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Total</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($carrito->productos as $producto)
                        <tr>
                            <td class="d-flex align-items-center gap-3">
                                <img src="{{ asset('storage/' . $producto->imagen_url) }}" alt="{{ $producto->nombre }}" style="width:60px; height:60px; object-fit:contain; border-radius:10px; border:1px solid #e0e0e0;">
                                <div>
                                    <span class="fw-semibold">{{ $producto->nombre }}</span>
                                    <div>
                                        <span class="badge" style="background-color:#81c784;">{{ $producto->categoria ?? 'Producto' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <form action="{{ route('carrito.actualizar') }}" method="POST" class="d-flex align-items-center gap-2">
                                    @csrf
                                    <input type="number" name="cantidad[{{ $producto->id }}]" value="{{ $producto->pivot->cantidad }}" min="1" class="form-control" style="width: 70px;">
                                    <button type="submit" class="btn btn-outline-success btn-sm" title="Actualizar cantidad">
                                        <i class="bi bi-arrow-repeat"></i> Actualizar
                                    </button>
                                </form>
                            </td>
                            <td>₡{{ number_format($producto->precio, 2) }}</td>
                            <td>₡{{ number_format($producto->precio * $producto->pivot->cantidad, 2) }}</td>
                            <td>
                                <a href="{{ route('carrito.eliminar', $producto->id) }}" class="btn btn-danger btn-sm" title="Eliminar">
                                    <i class="bi bi-trash"></i> Eliminar
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Resumen de costos -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm text-center" style="background-color:#e8f5e9;">
                    <div class="card-body">
                        <h6 class="card-title mb-1">Subtotal</h6>
                        <span class="fw-bold" style="color:#388e3c;">₡{{ number_format($total, 2) }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm text-center" style="background-color:#e8f5e9;">
                    <div class="card-body">
                        <h6 class="card-title mb-1">Impuesto (13%)</h6>
                        <span class="fw-bold" style="color:#388e3c;">₡{{ number_format($impuesto, 2) }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm text-center" style="background-color:#e8f5e9;">
                    <div class="card-body">
                        <h6 class="card-title mb-1">Envío</h6>
                        <span class="fw-bold" style="color:#388e3c;">₡{{ number_format($envio, 2) }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm text-center" style="background-color:#c8e6c9;">
                    <div class="card-body">
                        <h6 class="card-title mb-1">Total con impuestos</h6>
                        <span class="fw-bold fs-5" style="color:#1b5e20;">₡{{ number_format($totalConImpuesto, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botón de proceder a la compra -->
        <div class="text-center mt-4">
            <a href="{{ route('checkout') }}" class="btn btn-success btn-lg px-5" style="background-color:#4caf50; border:none;">
                <i class="bi bi-bag-check"></i> Proceder a la compra
            </a>
            
            <!-- Botón para limpiar carrito -->
            <a href="{{ route('carrito.limpiar') }}" 
               class="btn btn-warning btn-lg px-4 ms-3"
               onclick="return confirm('¿Estás seguro de que quieres limpiar el carrito?')"
               style="background-color:#ff9800; border:none;">
                🗑️ Limpiar Carrito
            </a>
        </div>
        @endif
    </div>
</section>
@endsection