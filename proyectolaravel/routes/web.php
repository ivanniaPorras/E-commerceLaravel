<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\ProductoController;


Route::get('/', fn() => view('home'));

Route::get('/pago', function() {
    return view('profile.pago'); 
}) ->name('pago');
Route::get('/pago', [App\Http\Controllers\PagoController::class, 'index'])->name('pago.index');

Route::get('/factura', function() {
    return view('profile.factura'); 
}) ->name('factura');
Route::get('/factura', [App\Http\Controllers\FacturaController::class, 'index'])->name('factura.index');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

require __DIR__ . '/auth.php';
Route::post('/carrito/agregar/{producto}', [CarritoController::class, 'agregar'])->name('carrito.agregar');
Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito.index');
Route::get('/carrito/eliminar/{id}', [CarritoController::class, 'eliminar'])->name('carrito.eliminar');
Route::post('/carrito/actualizar', [CarritoController::class, 'actualizar'])->name('carrito.actualizar');
Route::get('/', [ProductoController::class, 'index']);
Route::get('/checkout', [CarritoController::class, 'checkout'])->name('checkout');



