<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Verde Raíz') }}</title>

    {{-- Bootstrap 5 + Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    {{-- CSS propio de la tienda si lo tienes --}}
    {{-- <link rel="stylesheet" href="{{ asset('css/store.css') }}"> --}}
</head>

<body>
    {{-- Navbar pública --}}
    <nav class="navbar navbar-expand-lg bg-light border-bottom">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                <i class="bi bi-basket me-2"></i> {{ config('app.name', 'Laravel') }}
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#publicNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="publicNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Inicio</a></li>
                    {{-- más enlaces públicos si quieres --}}
                </ul>

                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-link nav-link" type="submit">Salir</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Iniciar sesión</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Registrarse</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    {{-- Contenido --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer style="background-color: #e6f2ed; color: #333;" class="mt-5">
        <div class="container py-4">
            <div class="row">
                <div class="col-md-4 mb-3">
                    {{-- Logo o descripción --}}
                    <h5 class="fw-bold">{{ config('app.name', 'Verde Raíz') }}</h5>
                    <p class="mb-0">¡Tus productos frescos de confianza!</p>
                </div>

                <div class="col-md-4 mb-3">
                    <h5 class="fw-bold">Enlaces</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ url('/') }}" class="text-decoration-none" style="color:#333;">Inicio</a>
                        </li>
                        <li><a href="#" class="text-decoration-none" style="color:#333;">Productos</a></li>
                        <li><a href="#" class="text-decoration-none" style="color:#333;">Contacto</a></li>
                    </ul>
                </div>

                <div class="col-md-4 mb-3">
                    <h5 class="fw-bold">Contacto</h5>
                    <p class="mb-1"><i class="bi bi-telephone-fill"></i> +506 1234-5678</p>
                    <p class="mb-0"><i class="bi bi-envelope-fill"></i> correo@ejemplo.com</p>
                </div>
            </div>

            <div class="text-center mt-3 border-top pt-3" style="border-color: rgba(0,0,0,0.1) !important;">
                &copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. Todos los derechos reservados.
            </div>
        </div>
    </footer>

    {{-- JS Bootstrap --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
