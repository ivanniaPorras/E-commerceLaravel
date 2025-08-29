<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\HomeController;


Route::get('/', fn() => view('home'));

Route::get('/pago', function () {
    return view('profile.pago');
})->name('pago');
Route::get('/pago', [App\Http\Controllers\PagoController::class, 'index'])->name('pago.index');

Route::get('/factura', function () {
    return view('profile.factura');
})->name('factura');
Route::get('/factura', [App\Http\Controllers\FacturaController::class, 'index'])->name('factura.index');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
Route::get('/', function () {return view('home');})->name('home');
Route::post('/carrito/agregar/{producto}', [CarritoController::class, 'agregar'])->name('carrito.agregar');
Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito.index');
Route::get('/carrito/eliminar/{id}', [CarritoController::class, 'eliminar'])->name('carrito.eliminar');
Route::post('/carrito/actualizar', [CarritoController::class, 'actualizar'])->name('carrito.actualizar');
Route::get('/', [ProductoController::class, 'index']);
//Route::get('/checkout', [CarritoController::class, 'checkout'])->name('checkout');
Route::get('/home', fn() => view('home'))->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/checkout', [App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout');
Route::post('/checkout/process', [App\Http\Controllers\CheckoutController::class, 'process'])->name('checkout.process');

// Rutas del Admin (requieren autenticación y ser admin)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard principal
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    
    // Gestión de usuarios
    Route::get('/users', function () {
        $users = \App\Models\User::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.users', compact('users'));
    })->name('users');
    
    // Crear usuario
    Route::get('/users/create', function () {
        return view('admin.users.create');
    })->name('users.create');
    
    // Guardar usuario
    Route::post('/users', function (\Illuminate\Http\Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'is_admin' => 'boolean'
        ]);
        
        $validated['password'] = bcrypt($validated['password']);
        $validated['is_admin'] = $request->has('is_admin');
        
        \App\Models\User::create($validated);
        
        return redirect()->route('admin.users')->with('success', 'Usuario creado correctamente');
    })->name('users.store');
    
    // Ver usuario específico
    Route::get('/users/{user}', function (\App\Models\User $user) {
        return view('admin.users.show', compact('user'));
    })->name('users.show');
    
    // Cambiar rol de admin
    Route::patch('/users/{user}/toggle-admin', function (\App\Models\User $user) {
        $user->update(['is_admin' => !$user->is_admin]);
        return back()->with('success', 
            $user->is_admin ? 'Usuario promovido a admin' : 'Usuario removido como admin'
        );
    })->name('users.toggle-admin');
    
    // Eliminar usuario
    Route::delete('/users/{user}', function (\App\Models\User $user) {
        if ($user->is_admin) {
            return back()->with('error', 'No se puede eliminar un administrador');
        }
        $user->delete();
        return back()->with('success', 'Usuario eliminado correctamente');
    })->name('users.destroy');
    
    // Gestión de productos
    Route::get('/products', function () {
        $productos = \App\Models\Producto::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.products', compact('productos'));
    })->name('products');
    
    // Crear producto
    Route::get('/products/create', function () {
        return view('admin.products.create');
    })->name('products.create');
    
    // Guardar producto
    Route::post('/products', function (\Illuminate\Http\Request $request) {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric|min:0',
            'categoria' => 'required|string|max:100',
            'stock' => 'required|integer|min:0',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        
        $producto = new \App\Models\Producto($validated);
        
        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('productos', 'public');
            $producto->imagen_url = $path;
        }
        
        $producto->save();
        
        return redirect()->route('admin.products')->with('success', 'Producto creado correctamente');
    })->name('products.store');
    
    // Editar producto
    Route::get('/products/{producto}/edit', function (\App\Models\Producto $producto) {
        return view('admin.products.edit', compact('producto'));
    })->name('products.edit');
    
    // Actualizar producto
    Route::put('/products/{producto}', function (\Illuminate\Http\Request $request, \App\Models\Producto $producto) {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric|min:0',
            'categoria' => 'required|string|max:100',
            'stock' => 'required|integer|min:0',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        
        $producto->update($validated);
        
        if ($request->hasFile('imagen')) {
            // Eliminar imagen anterior si existe
            if ($producto->imagen_url) {
                \Storage::disk('public')->delete($producto->imagen_url);
            }
            $path = $request->file('imagen')->store('productos', 'public');
            $producto->imagen_url = $path;
            $producto->save();
        }
        
        return redirect()->route('admin.products')->with('success', 'Producto actualizado correctamente');
    })->name('products.update');
    
    // Eliminar producto
    Route::delete('/products/{producto}', function (\App\Models\Producto $producto) {
        if ($producto->imagen_url) {
            \Storage::disk('public')->delete($producto->imagen_url);
        }
        $producto->delete();
        return redirect()->route('admin.products')->with('success', 'Producto eliminado correctamente');
    })->name('products.destroy');
    
    // Reportes
    Route::get('/reports', [App\Http\Controllers\Admin\ReporteController::class, 'index'])->name('reports');
    Route::get('/reports/exportar-pdf', [App\Http\Controllers\Admin\ReporteController::class, 'exportarVentasPDF'])->name('reports.exportar-pdf');
});
