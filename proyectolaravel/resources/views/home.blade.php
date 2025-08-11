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

    {{-- Producto 1 --}}
    <div class="col">
        <div class="card product-card h-100" data-name="miel organica pura" data-category="Endulzantes" data-price="6600">
            <img src="{{ asset('storage/ProductoMiel.png') }}" alt="Miel Orgánica" class="card-img-top" style="height:180px; object-fit:contain;">
            <div class="card-body d-flex flex-column">
                <h5 class="card-title">Miel Orgánica Pura</h5>
                <p class="card-text">Endulzante natural sin aditivos, rica en antioxidantes.</p>
                <p class="card-text mb-2"><strong>Precio:</strong> ₡6,600</p>
                <div class="d-flex justify-content-between mt-auto">
                    <span class="badge px-3 py-2" style="background-color:#81c784; font-size:0.85rem;">Endulzantes</span>
                    <button type="button" class="btn btn-success btn-sm" style="background-color:#4caf50; border:none;">Añadir al carrito</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Producto 2 --}}
    <div class="col">
        <div class="card product-card h-100" data-name="aceite de coco virgen" data-category="Aceites" data-price="5200">
            <img src="{{ asset('storage/ProductoAceiteCoco.png') }}" alt="Aceite de Coco" class="card-img-top" style="height:180px; object-fit:contain;">
            <div class="card-body d-flex flex-column">
                <h5 class="card-title">Aceite de Coco Virgen</h5>
                <p class="card-text">Prensado en frío, ideal para cocina y cuidado personal.</p>
                <p class="card-text mb-2"><strong>Precio:</strong> ₡5,200</p>
                <div class="d-flex justify-content-between mt-auto">
                    <span class="badge px-3 py-2" style="background-color:#81c784; font-size:0.85rem;">Aceites</span>
                    <button type="button" class="btn btn-success btn-sm" style="background-color:#4caf50; border:none;">Añadir al carrito</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Producto 3 --}}
    <div class="col">
        <div class="card product-card h-100" data-name="quinoa real" data-category="Granos" data-price="3550">
            <img src="{{ asset('storage/ProductoQuinoa.png') }}" alt="Quinoa Real" class="card-img-top" style="height:180px; object-fit:contain;">
            <div class="card-body d-flex flex-column">
                <h5 class="card-title">Quinoa Real</h5>
                <p class="card-text">Grano sin gluten, alto en proteína y fibra.</p>
                <p class="card-text mb-2"><strong>Precio:</strong> ₡3,550</p>
                <div class="d-flex justify-content-between mt-auto">
                    <span class="badge px-3 py-2" style="background-color:#81c784; font-size:0.85rem;">Granos</span>
                    <button type="button" class="btn btn-success btn-sm" style="background-color:#4caf50; border:none;">Añadir al carrito</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Producto 4 --}}
    <div class="col">
        <div class="card product-card h-100" data-name="granola sin azucar" data-category="Cereales" data-price="2850">
            <img src="{{ asset('storage/ProductoGranola.png') }}" alt="Granola Sin Azúcar" class="card-img-top" style="height:180px; object-fit:contain;">
            <div class="card-body d-flex flex-column">
                <h5 class="card-title">Granola Sin Azúcar</h5>
                <p class="card-text">A base de avena, frutos secos y dátiles.</p>
                <p class="card-text mb-2"><strong>Precio:</strong> ₡2,850</p>
                <div class="d-flex justify-content-between mt-auto">
                    <span class="badge px-3 py-2" style="background-color:#81c784; font-size:0.85rem;">Cereales</span>
                    <button type="button" class="btn btn-success btn-sm" style="background-color:#4caf50; border:none;">Añadir al carrito</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Producto 5 --}}
    <div class="col">
        <div class="card product-card h-100" data-name="kombucha de jengibre" data-category="Bebidas" data-price="1700">
            <img src="{{ asset('storage/ProductoKombucha.png') }}" alt="Kombucha de Jengibre" class="card-img-top" style="height:180px; object-fit:contain;">
            <div class="card-body d-flex flex-column">
                <h5 class="card-title">Kombucha de Jengibre</h5>
                <p class="card-text">Bebida probiótica fermentada y refrescante.</p>
                <p class="card-text mb-2"><strong>Precio:</strong> ₡1,700</p>
                <div class="d-flex justify-content-between mt-auto">
                    <span class="badge px-3 py-2" style="background-color:#81c784; font-size:0.85rem;">Bebidas</span>
                    <button type="button" class="btn btn-success btn-sm" style="background-color:#4caf50; border:none;">Añadir al carrito</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Producto 6 --}}
    <div class="col">
        <div class="card product-card h-100" data-name="te verde matcha" data-category="Tés" data-price="7900">
            <img src="{{ asset('storage/ProductoMatcha.png') }}" alt="Té Verde Matcha" class="card-img-top" style="height:180px; object-fit:contain;">
            <div class="card-body d-flex flex-column">
                <h5 class="card-title">Té Verde Matcha</h5>
                <p class="card-text">Polvo fino, alto en antioxidantes y energía natural.</p>
                <p class="card-text mb-2"><strong>Precio:</strong> ₡7,900</p>
                <div class="d-flex justify-content-between mt-auto">
                    <span class="badge px-3 py-2" style="background-color:#81c784; font-size:0.85rem;">Tés</span>
                    <button type="button" class="btn btn-success btn-sm" style="background-color:#4caf50; border:none;">Añadir al carrito</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Producto 7 --}}
    <div class="col">
        <div class="card product-card h-100" data-name="harina de almendra" data-category="Harinas" data-price="4000">
            <img src="{{ asset('storage/ProductoHarina.png') }}" alt="Harina de Almendra" class="card-img-top" style="height:180px; object-fit:contain;">
            <div class="card-body d-flex flex-column">
                <h5 class="card-title">Harina de Almendra</h5>
                <p class="card-text">Alternativa sin gluten para repostería saludable.</p>
                <p class="card-text mb-2"><strong>Precio:</strong> ₡4,000</p>
                <div class="d-flex justify-content-between mt-auto">
                    <span class="badge px-3 py-2" style="background-color:#81c784; font-size:0.85rem;">Harinas</span>
                    <button type="button" class="btn btn-success btn-sm" style="background-color:#4caf50; border:none;">Añadir al carrito</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Producto 8 --}}
    <div class="col">
        <div class="card product-card h-100" data-name="leche de avena" data-category="Bebidas Vegetales" data-price="1550">
            <img src="{{ asset('storage/ProductoLeche.png') }}" alt="Leche de Avena" class="card-img-top" style="height:180px; object-fit:contain;">
            <div class="card-body d-flex flex-column">
                <h5 class="card-title">Leche de Avena</h5>
                <p class="card-text">Bebida vegetal cremosa y sin lactosa.</p>
                <p class="card-text mb-2"><strong>Precio:</strong> ₡1,550</p>
                <div class="d-flex justify-content-between mt-auto">
                    <span class="badge px-3 py-2" style="background-color:#81c784; font-size:0.85rem;">Bebidas Vegetales</span>
                    <button type="button" class="btn btn-success btn-sm" style="background-color:#4caf50; border:none;">Añadir al carrito</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Producto 9 --}}
    <div class="col">
        <div class="card product-card h-100" data-name="chips de kale" data-category="Snacks" data-price="2200">
            <img src="{{ asset('storage/ProductoKale.png') }}" alt="Chips de Kale" class="card-img-top" style="height:180px; object-fit:contain;">
            <div class="card-body d-flex flex-column">
                <h5 class="card-title">Chips de Kale</h5>
                <p class="card-text">Crujientes, horneadas y sazonadas naturalmente.</p>
                <p class="card-text mb-2"><strong>Precio:</strong> ₡2,200</p>
                <div class="d-flex justify-content-between mt-auto">
                    <span class="badge px-3 py-2" style="background-color:#81c784; font-size:0.85rem;">Snacks</span>
                    <button type="button" class="btn btn-success btn-sm" style="background-color:#4caf50; border:none;">Añadir al carrito</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Producto 10 --}}
    <div class="col">
        <div class="card product-card h-100" data-name="semillas de chia" data-category="Semillas" data-price="1900">
            <img src="{{ asset('storage/ProductoChia.png') }}" alt="Semillas de Chía" class="card-img-top" style="height:180px; object-fit:contain;">
            <div class="card-body d-flex flex-column">
                <h5 class="card-title">Semillas de Chía</h5>
                <p class="card-text">Ricas en omega-3 y fibra, perfectas para puddings.</p>
                <p class="card-text mb-2"><strong>Precio:</strong> ₡1,900</p>
                <div class="d-flex justify-content-between mt-auto">
                    <span class="badge px-3 py-2" style="background-color:#81c784; font-size:0.85rem;">Semillas</span>
                    <button type="button" class="btn btn-success btn-sm" style="background-color:#4caf50; border:none;">Añadir al carrito</button>
                </div>
            </div>
        </div>
    </div>

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
