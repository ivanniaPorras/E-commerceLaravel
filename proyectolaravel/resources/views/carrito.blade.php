@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Carrito de Compras</h2>

        <table class="table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($carrito as $id => $item)
                    <tr>
                        <td>{{ $item['nombre'] }}</td>
                        <td>
                            <form action="{{ route('carrito.actualizar') }}" method="POST">
                                @csrf
                                <input type="number" name="cantidad[{{ $id }}]" value="{{ $item['cantidad'] }}" min="1" class="form-control" style="width: 60px;">
                        </td>
                        <td>{{ number_format($item['precio'], 2) }}</td>
                        <td>{{ number_format($item['precio'] * $item['cantidad'], 2) }}</td>
                        <td>
                            <button type="submit" class="btn btn-primary">Actualizar</button>
                            <a href="{{ route('carrito.eliminar', $id) }}" class="btn btn-danger">Eliminar</a>
                        </td>
                    </form>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-between">
            <h4>Total: ₡{{ number_format($total, 2) }}</h4>
            <h4>Impuesto (13%): ₡{{ number_format($impuesto, 2) }}</h4>
            <h4>Envío: ₡{{ number_format($envio, 2) }}</h4>
            <h4>Total con impuestos: ₡{{ number_format($totalConImpuesto, 2) }}</h4>
        </div>

        <a href="{{ route('checkout') }}" class="btn btn-success">Proceder a la compra</a>
    </div>
@endsection
