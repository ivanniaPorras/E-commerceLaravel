@extends('layouts.public')

@section('content')

<section class="text-center py-5" style="background-color: #f4f9f5;">
    <div class="container position-relative">
        <a href="{{ route('carrito.index') }}" class="btn btn-success position-absolute top-0 end-0 mt-3 me-3" title="Ver Carrito">
            <i class="bi bi-cart" style="font-size: 1.3rem;"></i>
        </a>
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
    </div>
</section>

<section id="productos" class="container my-5">
    <h2 class="text-center mb-4 primary-green">Productos Populares</h2>

    {{-- Filtros --}}
    <div class="card mb-4">
        <div class="card-body">
            <form class="row g-3 align-items-end" method="GET" action="{{ route('home') }}">
                <div class="col-md-4">
                    <label class="form-label">Buscar por nombre</label>
                    <input type="text" name="nombre" class="form-control" placeholder="Ej: miel, granola, matcha" value="{{ request('nombre') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Categoría</label>
                    <select name="categoria" class="form-select">
                        <option value="">Todas</option>
                        @php
                            $categorias = ['Endulzantes','Aceites','Granos','Cereales','Bebidas','Tés','Harinas','Bebidas Vegetales','Snacks','Suplementos','Semillas'];
                        @endphp
                        @foreach($categorias as $cat)
                            <option value="{{ $cat }}" {{ request('categoria') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Precio (CRC)</label>
                    <div class="d-flex gap-2">
                        <input type="number" name="precio_min" class="form-control" placeholder="Mín" value="{{ request('precio_min') }}">
                        <input type="number" name="precio_max" class="form-control" placeholder="Máx" value="{{ request('precio_max') }}">
                    </div>
                </div>
                <div class="col-12 d-flex gap-2">
                    <button type="submit" class="btn btn-success">Aplicar filtros</button>
                    <a href="{{ route('home') }}" class="btn btn-outline-secondary">Limpiar</a>
                </div>
            </form>
        </div>
    </div>

    {{-- Productos --}}
    <div id="products-grid" class="row row-cols-1 row-cols-md-3 g-4">
        @forelse($productos as $producto)
            <div class="col">
                <div class="card product-card h-100">
                    <img src="{{ asset('storage/' . $producto->imagen_url) }}" alt="{{ $producto->nombre }}" class="card-img-top" style="height:180px; object-fit:contain;">
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
        @empty
            <div class="col-12 text-center">
                <p class="text-muted">No se encontraron productos con los filtros aplicados.</p>
            </div>
        @endforelse
    </div>
</section>

@endsection
