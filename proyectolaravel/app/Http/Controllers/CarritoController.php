<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class CarritoController extends Controller
{
    // Mostrar el carrito
    public function index()
    {
        // Obtener el carrito de la sesión
        $carrito = session()->get('carrito', []);

        // Calcular el total del carrito
        $total = 0;
        foreach ($carrito as $item) {
            $total += $item['precio'] * $item['cantidad'];
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
        // Buscar el producto en la base de datos
        $producto = Producto::find($id);

        // Obtener el carrito de la sesión
        $carrito = session()->get('carrito', []);

        // Si el producto ya está en el carrito, aumentar la cantidad
        if (isset($carrito[$id])) {
            $carrito[$id]['cantidad']++;
        } else {
            // Si el producto no está en el carrito, agregarlo
            $carrito[$id] = [
                'nombre' => $producto->nombre,
                'precio' => $producto->precio,
                'cantidad' => 1,
                'imagen_url' => $producto->imagen_url
            ];
        }

        // Guardar el carrito actualizado en la sesión
        session()->put('carrito', $carrito);

        // Redirigir al carrito
        return redirect()->route('carrito.index');
    }

    // Eliminar un producto del carrito
    public function eliminar($id)
    {
        // Obtener el carrito de la sesión
        $carrito = session()->get('carrito', []);

        // Si el producto está en el carrito, eliminarlo
        if (isset($carrito[$id])) {
            unset($carrito[$id]);
            session()->put('carrito', $carrito); // Actualizar la sesión
        }

        // Redirigir al carrito
        return redirect()->route('carrito.index');
    }

    // Actualizar la cantidad de un producto en el carrito
    public function actualizar(Request $request)
    {
        // Obtener el carrito de la sesión
        $carrito = session()->get('carrito', []);

        // Actualizar las cantidades de los productos
        foreach ($request->cantidad as $id => $cantidad) {
            if (isset($carrito[$id])) {
                $carrito[$id]['cantidad'] = $cantidad;
            }
        }

        // Guardar el carrito actualizado en la sesión
        session()->put('carrito', $carrito);

        // Redirigir al carrito
        return redirect()->route('carrito.index');
    }
}
