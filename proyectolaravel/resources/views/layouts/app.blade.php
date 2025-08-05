<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verde Raíz - E-commerce</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        .primary-green { color: #4CAF50; }
        .footer { background-color: #f8f9fa; color: #6c757d; }
        .navbar-brand img { width: 40px; height: auto; }
        .navbar-nav .nav-link { color: #333 !important; }
        .footer { background-color: #f8f9fa; color: #6c757d; }
        .footer a { color: #333; }
    </style>
</head>
<body>
    <!-- Nav -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="#"> 
                <img src="{{ asset('storage/logoWeb.png') }}" alt="Logo"> Verde Raíz
            </a>
            <span class="navbar-text text-muted">Un Tesoro de Sabores</span>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Productos</a></li>
                </ul>
                <div class="d-flex">
                    <a class="btn btn-success ms-2" href="#">Carrito</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- contenido de la vista 'home' -->
    <div class="container mt-5">
        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="bg-light py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>Compañía</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-decoration-none text-dark">Sobre Nosotros</a></li>
                        <li><a href="#" class="text-decoration-none text-dark">Información de Pago</a></li>
                        <li><a href="#" class="text-decoration-none text-dark">Términos & Condiciones</a></li>
                        <li><a href="#" class="text-decoration-none text-dark">Contáctanos</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Categorías</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-decoration-none text-dark">Lácteos & Panes</a></li>
                        <li><a href="#" class="text-decoration-none text-dark">Frutas & Vegetales</a></li>
                        <li><a href="#" class="text-decoration-none text-dark">Snacks & Especias</a></li>
                        <li><a href="#" class="text-decoration-none text-dark">Jugos & Bebidas</a></li>
                        <li><a href="#" class="text-decoration-none text-dark">Pollo & Carne</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Subscribe Our Newsletter</h5>
                    <form>
                        <div class="mb-3">
                            <input type="email" class="form-control" id="newsletterEmail" placeholder="Enter your email">
                        </div>
                        <button type="submit" class="btn btn-success">Subscribe</button>
                    </form>
                    <div class="mt-3">
                        <a href="#" class="text-decoration-none text-dark me-2">Facebook</a>
                        <a href="#" class="text-decoration-none text-dark me-2">Twitter</a>
                        <a href="#" class="text-decoration-none text-dark me-2">Instagram</a>
                    </div>
                </div>
            </div>
            <div class="text-center mt-4">
                <p>&copy; 2025 Verde Raíz. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
