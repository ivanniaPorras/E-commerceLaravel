@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        
        <h2 class="text-center mb-4">Carrito de Compras</h2>

        
        <table class="table table-striped table-bordered">
            <thead>
                <tr class="table-success">
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
                        <td>
                            <!-- Imagen del producto -->
                            <img src="{{ asset('storage/' . $producto->imagen_url) }}" alt="{{ $producto->nombre }}" style="max-width: 50px; max-height: 50px;">
                            {{ $producto->nombre }}
                        </td>
                        <td>
                            <!-- Formulario para actualizar cantidad -->
                            <form action="{{ route('carrito.actualizar') }}" method="POST">
                                @csrf
                                <input type="number" name="cantidad[{{ $producto->id }}]" value="{{ $producto->pivot->cantidad }}" min="1" class="form-control" style="width: 80px;">
                        </td>
                        <td>{{ number_format($producto->precio, 2) }}</td>
                        <td>{{ number_format($producto->precio * $producto->pivot->cantidad, 2) }}</td>
                        <td>
                            <!-- Botones de acción -->
                            <button type="submit" class="btn btn-warning btn-sm">Actualizar</button>
                            <a href="{{ route('carrito.eliminar', $producto->id) }}" class="btn btn-danger btn-sm">Eliminar</a>
                        </td>
                    </form>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Resumen de costos -->
        <div class="d-flex justify-content-between border-top pt-3 mt-3">
            <h4>Total: ₡{{ number_format($total, 2) }}</h4>
            <h4>Impuesto (13%): ₡{{ number_format($impuesto, 2) }}</h4>
            <h4>Envío: ₡{{ number_format($envio, 2) }}</h4>
            <h4>Total con impuestos: ₡{{ number_format($totalConImpuesto, 2) }}</h4>
        </div>

        <!-- Botón de proceder a la compra -->
        <div class="text-center mt-4">
            <a href="{{ route('checkout') }}" class="btn btn-success btn-lg">Proceder a la compra</a>
        </div>
    </div>
@endsection
