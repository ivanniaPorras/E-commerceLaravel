<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\CheckoutController;

// Ruta principal (home)
Route::get('/', function () {
    return view('home');
})->name('home'); // Define el nombre de la ruta como 'home'

// Rutas para el carrito
Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito.index');

// Ruta para agregar un producto al carrito (con POST)
Route::post('/carrito/agregar/{id}', [CarritoController::class, 'agregar'])->name('carrito.agregar');

// Ruta para eliminar un producto del carrito
Route::get('/carrito/eliminar/{id}', [CarritoController::class, 'eliminar'])->name('carrito.eliminar');

// Ruta para actualizar la cantidad de un producto en el carrito
Route::post('/carrito/actualizar', [CarritoController::class, 'actualizar'])->name('carrito.actualizar');

// Ruta para el checkout
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout'); // Esta es la ruta para proceder al checkout

// Ruta para procesar el pago
Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');

// Ruta para la página de éxito después de un pago exitoso
Route::get('/checkout/success', function() {
    return view('checkout_success'); // Vista de éxito
})->name('checkout.success');
