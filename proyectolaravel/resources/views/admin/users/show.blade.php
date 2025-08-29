@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6 text-gray-900">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Detalles del Usuario</h1>
                        <p class="text-gray-600 mt-2">Información completa de {{ $user->name }}</p>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('admin.users') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md transition duration-200">
                            <i class="bi bi-arrow-left mr-2"></i>Volver a Usuarios
                        </a>
                        <a href="{{ route('admin.dashboard') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition duration-200">
                            <i class="bi bi-house mr-2"></i>Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Información del Usuario -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Información Personal</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <div class="flex items-center space-x-4 mb-4">
                            <div class="h-20 w-20 rounded-full bg-gray-300 flex items-center justify-center">
                                <span class="text-2xl font-bold text-gray-700">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                            </div>
                            <div>
                                <h4 class="text-xl font-semibold text-gray-900">{{ $user->name }}</h4>
                                <p class="text-gray-600">ID: {{ $user->id }}</p>
                                <div class="mt-2">
                                    @if($user->is_admin)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                            <i class="bi bi-shield-fill-check mr-2"></i>Administrador
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                            <i class="bi bi-person-fill mr-2"></i>Usuario
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $user->email }}</p>
                            @if($user->email_verified_at)
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 mt-1">
                                    <i class="bi bi-check-circle mr-1"></i>Verificado
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 mt-1">
                                    <i class="bi bi-exclamation-circle mr-1"></i>No verificado
                                </span>
                            @endif
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Fecha de Registro</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $user->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Última Actualización</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $user->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Acciones -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Acciones</h3>
                <div class="flex space-x-4">
                    <form action="{{ route('admin.users.toggle-admin', $user) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" 
                                class="bg-{{ $user->is_admin ? 'green' : 'red' }}-600 hover:bg-{{ $user->is_admin ? 'green' : 'red' }}-700 text-white px-4 py-2 rounded-md transition duration-200"
                                onclick="return confirm('¿Estás seguro de {{ $user->is_admin ? 'quitar' : 'dar' }} permisos de admin a {{ $user->name }}?')">
                            <i class="bi bi-{{ $user->is_admin ? 'person-down' : 'person-up' }} mr-2"></i>
                            {{ $user->is_admin ? 'Quitar Admin' : 'Hacer Admin' }}
                        </button>
                    </form>
                    
                    @if(!$user->is_admin)
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md transition duration-200"
                                onclick="return confirm('¿Estás seguro de eliminar a {{ $user->name }}? Esta acción no se puede deshacer.')">
                            <i class="bi bi-trash mr-2"></i>Eliminar Usuario
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
