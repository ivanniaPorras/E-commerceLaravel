<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarritoController;

// Ruta principal (home)
Route::get('/', function () {
    return view('home');
});

// Rutas para el carrito
Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito.index');

// Ruta para agregar un producto al carrito (con POST)
Route::post('/carrito/agregar/{id}', [CarritoController::class, 'agregar'])->name('carrito.agregar');

// Ruta para eliminar un producto del carrito
Route::get('/carrito/eliminar/{id}', [CarritoController::class, 'eliminar'])->name('carrito.eliminar');

// Ruta para actualizar la cantidad de un producto en el carrito
Route::post('/carrito/actualizar', [CarritoController::class, 'actualizar'])->name('carrito.actualizar');
