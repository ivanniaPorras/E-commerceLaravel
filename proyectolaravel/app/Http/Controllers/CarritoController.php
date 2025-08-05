<?php
namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class CarritoController extends Controller
{
    public function index()
    {
        $carrito = session()->get('carrito', []);
        $total = 0;
        foreach ($carrito as $item) {
            $total += $item['precio'] * $item['cantidad'];
        }

        $impuesto = $total * 0.13; // 13% de impuestos
        $envio = 5000; // Costo fijo de envío

        $totalConImpuesto = $total + $impuesto + $envio;

        return view('carrito', compact('carrito', 'total', 'impuesto', 'envio', 'totalConImpuesto'));
    }

    public function agregar($id)
    {
        $producto = Producto::find($id);
        $carrito = session()->get('carrito', []);

        if (isset($carrito[$id])) {
            $carrito[$id]['cantidad']++;
        } else {
            $carrito[$id] = [
                'nombre' => $producto->nombre,
                'precio' => $producto->precio,
                'cantidad' => 1,
                'imagen_url' => $producto->imagen_url
            ];
        }

        session()->put('carrito', $carrito);

        return redirect()->route('carrito.index');
    }

    public function eliminar($id)
    {
        $carrito = session()->get('carrito', []);

        if (isset($carrito[$id])) {
            unset($carrito[$id]);
            session()->put('carrito', $carrito);
        }

        return redirect()->route('carrito.index');
    }

    public function actualizar(Request $request)
    {
        $carrito = session()->get('carrito', []);

        foreach ($request->cantidad as $id => $cantidad) {
            if (isset($carrito[$id])) {
                $carrito[$id]['cantidad'] = $cantidad;
            }
        }

        session()->put('carrito', $carrito);

        return redirect()->route('carrito.index');
    }
}
