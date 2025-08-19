@extends('layouts.public')

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
            <input type="text" class="form-control me-2" placeholder="Buscar" style="max-width: 400px;">
            <button type="button" class="btn btn-success">Buscar</button>
        </div>
    </div>
</section>

<section id="productos" class="container my-5">
    <h2 class="text-center mb-4 primary-green">Productos Populares</h2>

    {{-- Filtros --}}
    <div class="card mb-4">
        <div class="card-body">
            <form class="row g-3 align-items-end" id="filters-form" onsubmit="return false;">
                <div class="col-md-4">
                    <label class="form-label">Buscar por nombre</label>
                    <input type="text" class="form-control" id="filter-name" placeholder="Ej: miel, granola, matcha">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Categoría</label>
                    <select id="filter-category" class="form-select">
                        <option value="">Todas</option>
                        <option>Endulzantes</option>
                        <option>Aceites</option>
                        <option>Granos</option>
                        <option>Cereales</option>
                        <option>Bebidas</option>
                        <option>Tés</option>
                        <option>Harinas</option>
                        <option>Bebidas Vegetales</option>
                        <option>Snacks</option>
                        <option>Suplementos</option>
                        <option>Semillas</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Precio (CRC)</label>
                    <div class="d-flex gap-2">
                        <input type="number" step="1" min="0" class="form-control" id="filter-min" placeholder="Mín">
                        <input type="number" step="1" min="0" class="form-control" id="filter-max" placeholder="Máx">
                    </div>
                </div>
                <div class="col-12 d-flex gap-2">
                    <button class="btn btn-success" id="btn-apply">Aplicar filtros</button>
                    <button class="btn btn-outline-secondary" id="btn-reset">Limpiar</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Productos --}}
    <div id="products-grid" class="row row-cols-1 row-cols-md-3 g-4">
        @foreach($productos as $producto)
            <div class="col">
                <div class="card product-card h-100" data-name="{{ $producto->nombre }}" data-category="{{ $producto->categoria }}" data-price="{{ $producto->precio }}">
                    <img src="{{ asset('storage/' . $producto->imagen) }}" alt="{{ $producto->nombre }}" class="card-img-top" style="height:180px; object-fit:contain;">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $producto->nombre }}</h5>
                        <p class="card-text">{{ $producto->descripcion }}</p>
                        <p class="card-text mb-2"><strong>Precio:</strong> ₡{{ number_format($producto->precio, 2) }}</p>
                        <div class="d-flex justify-content-between mt-auto">
                            <span class="badge px-3 py-2" style="background-color:#81c784; font-size:0.85rem;">{{ $producto->categoria }}</span>
                            <form action="{{ route('carrito.agregar', $producto->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm" style="background-color:#4caf50; border:none;">Añadir al carrito</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>

@endsection
