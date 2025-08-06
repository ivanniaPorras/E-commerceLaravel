@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>¡Compra Exitosa!</h2>
        <p>Gracias por tu compra. Tu pedido ha sido procesado correctamente.</p>
        <a href="{{ route('home') }}" class="btn btn-success">Volver a la página principal</a>
    </div>
@endsection
