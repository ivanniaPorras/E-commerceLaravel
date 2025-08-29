<?php

namespace App\Http\Controllers;

use App\Models\Carrito;  // Importar el modelo Carrito
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FacturaController extends Controller
{
    public function index()
    {
        // Obtener el carrito de compras del usuario autenticado
        $carrito = Carrito::with('productos')->where('user_id', Auth::id())->first(); // Usar Auth::id()
        
        if (!$carrito) {
            return redirect()->route('carrito.index')->with('error', 'No hay productos en tu carrito.');
        }

        // Calcular el total de la compra (sin impuestos ni envío)
        $total = 0;
        foreach ($carrito->productos as $item) {
            $total += $item->pivot->cantidad * $item->precio;
        }
        
        // Calcular impuestos (13%)
        $impuesto = $total * 0.13;

        // Costo fijo de envío (puedes ajustar este valor según tu lógica)
        $envio = 5000; // Costo fijo de envío
        
        // Calcular el total con impuestos y envío
        $totalConImpuesto = $total + $impuesto + $envio;

        // Generar un ID único para la compra
        $orderId = 'ORD-' . time() . '-' . rand(1000, 9999);

        // Fecha de compra
        $fechaCompra = now()->format('d M Y');

        // Pasar los datos a la vista
        return view('factura', compact('carrito', 'total', 'impuesto', 'envio', 'totalConImpuesto', 'orderId', 'fechaCompra'));
    }
}
