@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6 text-gray-900">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Gestión de Productos</h1>
                        <p class="text-gray-600 mt-2">Administra todos los productos del catálogo</p>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('admin.dashboard') }}" 
                           style="background-color: #059669; color: white; padding: 8px 16px; border-radius: 6px; text-decoration: none; font-weight: 500; transition: background-color 0.2s;"
                           onmouseover="this.style.backgroundColor='#047857'"
                           onmouseout="this.style.backgroundColor='#059669'">
                            <i class="bi bi-house mr-2"></i>Dashboard
                        </a>
                        <a href="{{ route('admin.products.create') }}" 
                           style="background-color: #059669; color: white; padding: 8px 16px; border-radius: 6px; text-decoration: none; font-weight: 500; transition: background-color 0.2s;"
                           onmouseover="this.style.backgroundColor='#047857'"
                           onmouseout="this.style.backgroundColor='#059669'">
                            <i class="bi bi-plus mr-2"></i>Nuevo Producto
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtros -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6">
                <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Buscar</label>
                        <input type="text" name="search" value="{{ request('search') }}" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                               placeholder="Nombre o descripción">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Categoría</label>
                        <select name="categoria" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Todas</option>
                            @php
                                $categorias = ['Endulzantes','Aceites','Granos','Cereales','Bebidas','Tés','Harinas','Bebidas Vegetales','Snacks','Suplementos','Semillas'];
                            @endphp
                            @foreach($categorias as $cat)
                                <option value="{{ $cat }}" {{ request('categoria') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Ordenar por</label>
                        <select name="sort_by" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="created_at" {{ request('sort_by') === 'created_at' ? 'selected' : '' }}>Fecha de creación</option>
                            <option value="nombre" {{ request('sort_by') === 'nombre' ? 'selected' : '' }}>Nombre</option>
                            <option value="precio" {{ request('sort_by') === 'precio' ? 'selected' : '' }}>Precio</option>
                            <option value="categoria" {{ request('sort_by') === 'categoria' ? 'selected' : '' }}>Categoría</option>
                        </select>
                    </div>
                    
                    <div class="flex items-end">
                        <button type="submit" 
                                style="background-color: #059669; color: white; padding: 8px 16px; border-radius: 6px; border: none; font-weight: 500; cursor: pointer; transition: background-color 0.2s;"
                                onmouseover="this.style.backgroundColor='#047857'"
                                onmouseout="this.style.backgroundColor='#059669'">
                            <i class="bi bi-funnel mr-2"></i>Filtrar
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabla de productos -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Producto</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categoría</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Precio</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Creado</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($productos as $producto)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="flex items-center">
                                                                                 <div class="flex-shrink-0 h-8 w-8">
                                             @if($producto->imagen_url)
                                                 <img src="{{ asset('storage/' . $producto->imagen_url) }}" 
                                                      alt="{{ $producto->nombre }}" 
                                                      class="h-8 w-8 object-cover rounded-md">
                                             @else
                                                 <div class="h-8 w-8 bg-gray-300 rounded-md flex items-center justify-center">
                                                     <i class="bi bi-image text-gray-500 text-xs"></i>
                                                 </div>
                                             @endif
                                         </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900">{{ $producto->nombre }}</div>
                                            <div class="text-xs text-gray-500 truncate max-w-32">{{ $producto->descripcion }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $producto->categoria ?? 'Sin categoría' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                    ₡{{ number_format($producto->precio, 2) }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $producto->stock > 10 ? 'bg-green-100 text-green-800' : ($producto->stock > 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                        {{ $producto->stock }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                    <div>{{ $producto->created_at->format('d/m/Y') }}</div>
                                    <div class="text-xs text-gray-500">{{ $producto->created_at->format('H:i') }}</div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.products.edit', $producto) }}" 
                                           class="text-indigo-600 hover:text-indigo-900 p-1 rounded hover:bg-indigo-50 transition-colors">
                                            <i class="bi bi-pencil text-lg"></i>
                                        </a>
                                        
                                        <form action="{{ route('admin.products.destroy', $producto) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-red-600 hover:text-red-900 p-1 rounded hover:bg-red-50 transition-colors"
                                                    onclick="return confirm('¿Estás seguro de eliminar este producto? Esta acción no se puede deshacer.')">
                                                <i class="bi bi-trash text-lg"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                                    No se encontraron productos con los filtros aplicados.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Paginación -->
                @if($productos->hasPages())
                <div class="mt-4">
                    {{ $productos->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
