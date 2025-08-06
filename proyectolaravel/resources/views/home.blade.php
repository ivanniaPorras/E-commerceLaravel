@extends('layouts.app')

@section('content')

<section class="text-center py-5" style="background-color: #f4f9f5;">
    <div class="container">
        <h2 class="display-4 fw-bold text-dark">100% Vegetales Orgánicos</h2>
        <p class="text-muted mb-4">La Mejor Manera de Llenar tu Billetera.</p>
        <p class="text-muted mb-5">Inicia tu Día con Ingredientes Frescos.</p>

        <div class="mb-4">
            <span class="badge bg-success me-2">Compra</span>
            <span class="badge bg-success me-2">Recetas</span>
            <span class="badge bg-success me-2">Cocina</span>
            <span class="badge bg-success me-2">Ingredientes</span>
            <span class="badge bg-success me-2">Comida</span>
        </div>

        <div class="d-flex justify-content-center">
            <input type="email" class="form-control me-2" placeholder="Buscar" style="max-width: 400px;">
            <button type="submit" class="btn btn-success">Buscar</button>
        </div>
    </div>
</section>

<section class="container my-5">
    <div class="row text-center">
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm rounded h-100" style="background-color: #f1f8e9;">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title text-dark">Todos los días frescos y limpios con nuestros productos</h5>
                    <p class="card-text text-dark flex-grow-1">Obtén los mejores productos orgánicos y frescos entregados directamente a tu puerta.</p>
                    <a href="#" class="btn btn-success mt-auto py-2">Comprar ahora</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm rounded h-100" style="background-color: #fce4ec;">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title text-dark">Haz tu desayuno saludable y fácil</h5>
                    <p class="card-text text-dark flex-grow-1">Elige entre nuestra variedad de productos saludables para el desayuno y comienza tu día de la mejor manera.</p>
                    <a href="#" class="btn btn-success mt-auto py-2">Comprar ahora</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm rounded h-100" style="background-color: #e3f2fd;">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title text-dark">Los mejores productos orgánicos en línea</h5>
                    <p class="card-text text-dark flex-grow-1">Ofrecemos solo los mejores productos orgánicos para nutrir tu cuerpo.</p>
                    <a href="#" class="btn btn-success mt-auto py-2">Comprar ahora</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="productos" class="container my-5">
    <h2 class="text-center mb-4 primary-green">Productos Populares</h2>
    <div class="row row-cols-1 row-cols-md-3 g-4">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Producto 1</h5>
                    <p class="card-text">Descripción del producto.</p>
                    <p class="card-text">Precio: $10.00</p>
                    <form action="{{ route('carrito.agregar', 1) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">Añadir al carrito</button>
                    </form>
                </div>
            </div>
        </div>
        <!-- Aquí debes poner más productos según tu lógica -->
    </div>
</section>

<section class="container my-5">
    <div class="row text-center">
        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm rounded-3 h-100" style="background-color: #f9f9f9; transition: transform 0.3s ease-in-out;">
                <div class="card-body d-flex flex-column align-items-center p-4">
                    <i class="bi bi-trophy" style="font-size: 40px; margin-bottom: 15px; color: #388E3C;"></i>
                    <h5 class="card-title text-dark">Los Mejores Precios & Ofertas</h5>
                    <p class="card-text text-muted">Órdenes desde ₡2000</p>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm rounded-3 h-100" style="background-color: #f9f9f9; transition: transform 0.3s ease-in-out;">
                <div class="card-body d-flex flex-column align-items-center p-4">
                    <i class="bi bi-taxi-front" style="font-size: 40px; margin-bottom: 15px; color: #388E3C;"></i>
                    <h5 class="card-title text-dark">Envío Gratis</h5>
                    <p class="card-text text-muted">24/7 excelente servicio</p>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm rounded-3 h-100" style="background-color: #f9f9f9; transition: transform 0.3s ease-in-out;">
                <div class="card-body d-flex flex-column align-items-center p-4">
                    <i class="bi bi-currency-dollar" style="font-size: 40px; margin-bottom: 15px; color: #388E3C;"></i>
                    <h5 class="card-title text-dark">Gran Oferta Diaria</h5>
                    <p class="card-text text-muted">Aprovéchala</p>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm rounded-3 h-100" style="background-color: #f9f9f9; transition: transform 0.3s ease-in-out;">
                <div class="card-body d-flex flex-column align-items-center p-4">
                    <i class="bi bi-handbag" style="font-size: 40px; margin-bottom: 15px; color: #388E3C;"></i>
                    <h5 class="card-title text-dark">Amplia Variedad</h5>
                    <p class="card-text text-muted">Mega Descuentos</p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
