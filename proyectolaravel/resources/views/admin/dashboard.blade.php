@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header del Panel -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6 text-gray-900">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Panel de Administración</h1>
                        <p class="text-gray-600 mt-2">Bienvenido, {{ auth()->user()->name }}!</p>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('admin.users') }}" 
                           style="background-color: #059669; color: white; padding: 8px 16px; border-radius: 6px; text-decoration: none; font-weight: 500; transition: background-color 0.2s;"
                           onmouseover="this.style.backgroundColor='#047857'"
                           onmouseout="this.style.backgroundColor='#059669'">
                            <i class="bi bi-people-fill mr-2"></i>Gestionar Usuarios
                        </a>
                        <a href="{{ route('admin.products') }}" 
                           style="background-color: #059669; color: white; padding: 8px 16px; border-radius: 6px; text-decoration: none; font-weight: 500; transition: background-color 0.2s;"
                           onmouseover="this.style.backgroundColor='#047857'"
                           onmouseout="this.style.backgroundColor='#059669'">
                            <i class="bi bi-box-seam-fill mr-2"></i>Gestionar Productos
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Estadísticas Principales -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            <!-- Total Usuarios -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center">
                                <i class="bi bi-people-fill text-white"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Total Usuarios</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ \App\Models\User::count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Usuarios Admin -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-red-500 rounded-md flex items-center justify-center">
                                <i class="bi bi-shield-fill-check text-white"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Usuarios Admin</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ \App\Models\User::where('is_admin', true)->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Productos -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center">
                                <i class="bi bi-box-seam-fill text-white"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Total Productos</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ \App\Models\Producto::count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Pedidos -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-yellow-500 rounded-md flex items-center justify-center">
                                <i class="bi bi-cart-check-fill text-white"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Total Pedidos</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ \App\Models\Pedido::count() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

                 <!-- Gráficos y Tablas -->
         <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Usuarios Recientes -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Usuarios Recientes</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usuario</th>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Admin</th>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Registrado</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach(\App\Models\User::orderBy('created_at', 'desc')->take(5)->get() as $user)
                                <tr>
                                    <td class="px-3 py-2 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                    </td>
                                    <td class="px-3 py-2 whitespace-nowrap">
                                        @if($user->is_admin)
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                Sí
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                No
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500">
                                        {{ $user->created_at->format('d/m/Y') }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('admin.users') }}" 
                           style="color: #059669; font-weight: 500; font-size: 14px; text-decoration: none;"
                           onmouseover="this.style.color='#047857'"
                           onmouseout="this.style.color='#059669'">
                            Ver todos los usuarios →
                        </a>
                    </div>
                </div>
            </div>

            <!-- Productos Populares -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Productos Destacados</h3>
                    <div class="space-y-3">
                        @foreach(\App\Models\Producto::take(5)->get() as $producto)
                        <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                            <div class="flex-shrink-0">
                                                                 @if($producto->imagen_url)
                                     <img src="{{ asset('storage/' . $producto->imagen_url) }}" 
                                          alt="{{ $producto->nombre }}" 
                                          class="w-8 h-8 object-cover rounded-md">
                                 @else
                                     <div class="w-8 h-8 bg-gray-300 rounded-md flex items-center justify-center">
                                         <i class="bi bi-image text-gray-500 text-xs"></i>
                                     </div>
                                 @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $producto->nombre }}</p>
                                <p class="text-sm text-gray-500">₡{{ number_format($producto->precio, 2) }}</p>
                            </div>
                            <div class="flex-shrink-0">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $producto->categoria }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('admin.products') }}" 
                           style="color: #059669; font-weight: 500; font-size: 14px; text-decoration: none;"
                           onmouseover="this.style.color='#047857'"
                           onmouseout="this.style.color='#059669'">
                            Ver todos los productos →
                        </a>
                    </div>
                </div>
            </div>
        </div>

                 <!-- Acciones Rápidas -->
         <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-8">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Acciones Rápidas</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <a href="{{ route('admin.users.create') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition duration-200">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i class="bi bi-person-plus-fill text-blue-600"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-sm font-medium text-gray-900">Crear Usuario</h4>
                            <p class="text-sm text-gray-500">Agregar nuevo usuario al sistema</p>
                        </div>
                    </a>

                    <a href="{{ route('admin.products.create') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition duration-200">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                <i class="bi bi-plus-square-fill text-green-600"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-sm font-medium text-gray-900">Agregar Producto</h4>
                            <p class="text-sm text-gray-500">Crear nuevo producto en el catálogo</p>
                        </div>
                    </a>

                    <a href="{{ route('admin.reports') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition duration-200">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                <i class="bi bi-graph-up text-purple-600"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-sm font-medium text-gray-900">Ver Reportes</h4>
                            <p class="text-sm text-gray-500">Análisis y estadísticas del sistema</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

