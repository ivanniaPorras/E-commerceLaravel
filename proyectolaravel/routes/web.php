<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarritoController;

Route::get('/', function () {
    return view('home');
});

// Rutas para el carrito
Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito.index');
Route::get('/carrito/agregar/{id}', [CarritoController::class, 'agregar'])->name('carrito.agregar');
Route::get('/carrito/eliminar/{id}', [CarritoController::class, 'eliminar'])->name('carrito.eliminar');
Route::post('/carrito/actualizar', [CarritoController::class, 'actualizar'])->name('carrito.actualizar');
