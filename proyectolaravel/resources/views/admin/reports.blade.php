@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6 text-gray-900">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Reportes y Estadísticas</h1>
                        <p class="text-gray-600 mt-2">Análisis completo del sistema</p>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('admin.dashboard') }}" 
                           style="background-color: #059669; color: white; padding: 8px 16px; border-radius: 6px; text-decoration: none; font-weight: 500; transition: background-color 0.2s;"
                           onmouseover="this.style.backgroundColor='#047857'"
                           onmouseout="this.style.backgroundColor='#059669'">
                            <i class="bi bi-arrow-left mr-2"></i>Volver al Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Estadísticas Generales -->
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
                            <p class="text-2xl font-semibold text-gray-900">{{ $totalUsuarios }}</p>
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
                            <p class="text-2xl font-semibold text-gray-900">{{ $totalProductos }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Ventas -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-yellow-500 rounded-md flex items-center justify-center">
                                <i class="bi bi-cart-check-fill text-white"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Total Ventas</p>
                            <p class="text-2xl font-semibold text-gray-900">₡{{ number_format($totalVentas, 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reporte de Ventas -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Reporte de Ventas</h3>
                    <form action="{{ route('admin.reports.exportar-pdf') }}" method="GET" class="flex space-x-3">
                        <input type="date" name="fecha_inicio" value="{{ now()->startOfMonth()->format('Y-m-d') }}" 
                               class="border border-gray-300 rounded-md px-3 py-2 text-sm">
                        <input type="date" name="fecha_fin" value="{{ now()->endOfMonth()->format('Y-m-d') }}" 
                               class="border border-gray-300 rounded-md px-3 py-2 text-sm">
                        <button type="submit" 
                                style="background-color: #059669; color: white; padding: 8px 16px; border-radius: 6px; border: none; font-weight: 500; cursor: pointer; transition: background-color 0.2s;"
                                onmouseover="this.style.backgroundColor='#047857'"
                                onmouseout="this.style.backgroundColor='#059669'">
                            <i class="bi bi-file-pdf mr-2"></i>Exportar PDF
                        </button>
                    </form>
                </div>
                
                <!-- Ventas por Mes -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div>
                        <h4 class="text-md font-semibold text-gray-900 mb-4">Ventas por Mes ({{ now()->year }})</h4>
                        <div class="space-y-0">
                            @foreach($ventasPorMes as $venta)
                            <div class="flex items-center justify-between py-2 {{ !$loop->last ? 'border-b border-gray-200' : '' }}">
                                <span class="text-sm font-medium text-gray-700 w-12">{{ $venta['mes'] }}</span>
                                <div class="flex items-center">
                                    <div class="w-24 bg-gray-200 rounded-full h-2 mr-2">
                                        <div class="bg-yellow-600 h-2 rounded-full" style="width: {{ $venta['total'] > 0 ? min(100, ($venta['total'] / max(array_column($ventasPorMes, 'total'))) * 100) : 0 }}%"></div>
                                    </div>
                                    <span class="text-sm text-gray-600 w-16 text-right">CRC {{ number_format($venta['total'], 0) }}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <div>
                        <h4 class="text-md font-semibold text-gray-900 mb-4">Categorías Más Vendidas</h4>
                        <div class="space-y-0">
                            @forelse($categoriasMasVendidas as $categoria)
                            <div class="flex items-center justify-between py-2 {{ !$loop->last ? 'border-b border-gray-200' : '' }}">
                                <span class="text-sm font-medium text-gray-700 flex-1">{{ $categoria->categoria ?? 'Sin categoría' }}</span>
                                <div class="flex items-center">
                                    <div class="w-24 bg-gray-200 rounded-full h-2 mr-2">
                                        <div class="bg-green-600 h-2 rounded-full" style="width: {{ ($categoria->total_ventas / $categoriasMasVendidas->sum('total_ventas')) * 100 }}%"></div>
                                    </div>
                                    <span class="text-sm text-gray-600 w-16 text-right">CRC {{ number_format($categoria->total_ventas, 0) }}</span>
                                </div>
                            </div>
                            @empty
                            <p class="text-gray-500 text-center">No hay datos de ventas por categoría</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Análisis Detallado -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Usuarios por Mes -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Usuarios Registrados por Mes</h3>
                    <div class="space-y-3">
                        @php
                            $currentYear = now()->year;
                            $months = [];
                            for ($i = 1; $i <= 12; $i++) {
                                $month = \Carbon\Carbon::createFromDate($currentYear, $i, 1);
                                $count = \App\Models\User::whereYear('created_at', $currentYear)
                                                        ->whereMonth('created_at', $i)
                                                        ->count();
                                $months[] = [
                                    'name' => $month->format('M'),
                                    'count' => $count
                                ];
                            }
                        @endphp
                        
                        @foreach($months as $month)
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-700">{{ $month['name'] }}</span>
                            <div class="flex items-center">
                                <div class="w-32 bg-gray-200 rounded-full h-2 mr-3">
                                    <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $month['count'] > 0 ? min(100, ($month['count'] / max(array_column($months, 'count'))) * 100) : 0 }}%"></div>
                                </div>
                                <span class="text-sm text-gray-600 w-8 text-right">{{ $month['count'] }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Productos por Categoría -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Productos por Categoría</h3>
                    <div class="space-y-3">
                        @php
                            $categorias = \App\Models\Producto::selectRaw('categoria, COUNT(*) as total')
                                                              ->groupBy('categoria')
                                                              ->orderBy('total', 'desc')
                                                              ->get();
                        @endphp
                        
                        @forelse($categorias as $categoria)
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-700">{{ $categoria->categoria ?? 'Sin categoría' }}</span>
                            <div class="flex items-center">
                                <div class="w-32 bg-gray-200 rounded-full h-2 mr-3">
                                    <div class="bg-green-600 h-2 rounded-full" style="width: {{ ($categoria->total / $categorias->sum('total')) * 100 }}%"></div>
                                </div>
                                <span class="text-sm text-gray-600 w-8 text-right">{{ $categoria->total }}</span>
                            </div>
                        </div>
                        @empty
                        <p class="text-gray-500 text-center">No hay productos categorizados</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Productos Más Vendidos y Usuarios Top -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Productos Más Vendidos -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Productos Más Vendidos</h3>
                                            <div class="space-y-0">
                            @forelse($productosMasVendidos as $producto)
                            <div class="flex items-center justify-between p-2 {{ !$loop->last ? 'border-b border-gray-200' : '' }}">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $producto->nombre }}</p>
                                    <p class="text-xs text-gray-500">{{ $producto->categoria }}</p>
                                </div>
                                <span class="text-sm font-semibold text-gray-900">{{ $producto->total_vendido }} unidades</span>
                            </div>
                            @empty
                            <p class="text-gray-500 text-center">No hay datos de productos vendidos</p>
                            @endforelse
                        </div>
                </div>
            </div>

            <!-- Usuarios Top -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Usuarios con Más Compras</h3>
                                            <div class="space-y-0">
                            @forelse($usuariosTop as $usuario)
                            <div class="flex items-center justify-between p-2 {{ !$loop->last ? 'border-b border-gray-200' : '' }}">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $usuario->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $usuario->email }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-semibold text-gray-900">{{ $usuario->total_pedidos }} pedidos</p>
                                    <p class="text-xs text-gray-600">CRC {{ number_format($usuario->total_gastado, 0) }}</p>
                                </div>
                            </div>
                            @empty
                            <p class="text-gray-500 text-center">No hay datos de usuarios</p>
                            @endforelse
                        </div>
                </div>
            </div>
        </div>

        <!-- Tabla de Actividad Reciente -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Actividad Reciente del Sistema</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usuario</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acción</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @php
                                $recentUsers = \App\Models\User::orderBy('created_at', 'desc')->take(10)->get();
                            @endphp
                            
                            @foreach($recentUsers as $user)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8">
                                            <div class="h-8 w-8 rounded-full bg-gray-300 flex items-center justify-center">
                                                <span class="text-xs font-medium text-gray-700">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="bi bi-person-plus mr-1"></i>Registro
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $user->created_at->format('d/m/Y H:i') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
