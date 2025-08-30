<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\DetallePedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Carrito; 

class FacturaController extends Controller
{
    public function index()
    {
        // Obtener el ID del pedido desde la sesión
        $pedidoId = session('pedido_id');
        
        if (!$pedidoId) {
            return redirect()->route('carrito.index')->with('error', 'No hay pedido para mostrar en la factura.');
        }

        // Obtener el pedido con sus detalles y productos
        $pedido = Pedido::with(['detalles.producto', 'user'])->find($pedidoId);
        
        if (!$pedido) {
            return redirect()->route('carrito.index')->with('error', 'Pedido no encontrado.');
        }

        // Verificar que el pedido pertenezca al usuario autenticado
        if ($pedido->user_id !== Auth::id()) {
            abort(403, 'No tienes permiso para ver esta factura.');
        }

        // Calcular totales
        $subtotal = $pedido->detalles->sum('subtotal');
        $impuesto = $subtotal * 0.13;
        $envio = 5000;
        $total = $pedido->total;

        // Generar un ID único para la factura
        $facturaId = 'FAC-' . $pedido->id . '-' . time();

        // Fecha de compra
        $fechaCompra = $pedido->fecha_pedido->format('d M Y');

        // Pasar los datos a la vista
        return view('factura', compact(
            'pedido', 
            'subtotal', 
            'impuesto', 
            'envio', 
            'total', 
            'facturaId', 
            'fechaCompra'
        ));
    }

    // Método privado para limpiar el carrito después de mostrar la factura
    private function limpiarCarritoDespuesDeFactura()
    {
        $carrito = Carrito::where('user_id', Auth::id())->first();
        
        if ($carrito) {
            $carrito->productos()->detach();
            session()->forget(['carrito']);
        }
    }
}
