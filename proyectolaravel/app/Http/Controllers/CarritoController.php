<?php

namespace App\Http\Controllers;

use App\Models\Carrito;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarritoController extends Controller
{
    // Mostrar el carrito
    public function index()
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            return redirect()->route('login'); 
        }

        // Obtener el carrito del usuario
        $carrito = Carrito::with('productos')->where('user_id', Auth::id())->first();

        // Si no existe el carrito, crearlo
        if (!$carrito) {
            $carrito = Carrito::create(['user_id' => Auth::id()]);
        }

        // Si el carrito no tiene productos, asignar un array vacío
        $productos = $carrito->productos ?? collect();

        // Calcular el total del carrito
        $total = 0;
        foreach ($productos as $item) {
            $total += $item->pivot->cantidad * $item->precio;
        }

        // Calcular impuestos y envío
        $impuesto = $total * 0.13; // 13% de impuestos
        $envio = 5000; // Costo fijo de envío

        // Calcular el total con impuestos y envío
        $totalConImpuesto = $total + $impuesto + $envio;

        // Retornar la vista 'carrito' con los datos
        return view('carrito', compact('carrito', 'total', 'impuesto', 'envio', 'totalConImpuesto'));
    }

    // Agregar un producto al carrito
    public function agregar($id)
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            return redirect()->route('login'); 
        }

        // Buscar el producto en la base de datos
        $producto = Producto::findOrFail($id);

        // Obtener el carrito del usuario
        $carrito = Carrito::where('user_id', Auth::id())->first();

        // Si el carrito no existe, crearlo
        if (!$carrito) {
            $carrito = Carrito::create(['user_id' => Auth::id()]);
        }

        // Si el producto ya está en el carrito, aumentar la cantidad
        $carritoProducto = $carrito->productos()->where('producto_id', $id)->first();
        if ($carritoProducto) {
            $carrito->productos()->updateExistingPivot($id, ['cantidad' => $carritoProducto->pivot->cantidad + 1]);
        } else {
            // Si el producto no está en el carrito, agregarlo
            $carrito->productos()->attach($id, ['cantidad' => 1]);
        }

        return redirect()->route('carrito.index');
    }

    // Eliminar un producto del carrito
    public function eliminar($id)
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $carrito = Carrito::where('user_id', Auth::id())->first();

        // Si el carrito existe, eliminar el producto
        if ($carrito) {
            $carrito->productos()->detach($id);
        }

        // Redirigir al carrito
        return redirect()->route('carrito.index');
    }

    // Actualizar la cantidad de un producto en el carrito
    public function actualizar(Request $request)
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            return redirect()->route('login'); 
        }

        $carrito = Carrito::where('user_id', Auth::id())->first();

        // Si el carrito existe, actualizar las cantidades de los productos
        if ($carrito) {
            foreach ($request->cantidad as $id => $cantidad) {
                if ($carrito->productos()->where('producto_id', $id)->exists()) {
                    $carrito->productos()->updateExistingPivot($id, ['cantidad' => $cantidad]);
                }
            }
        }
        return redirect()->route('carrito.index');
    }

    // Checkout (pago)
    public function checkout()
    {
        return view('checkout'); 
    }
}
