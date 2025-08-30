<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FacturaController extends Controller
{
    // Ajustes de cálculo (modifica si lo necesitas)
    private const TAX_RATE   = 0.13;
    private const ENVIO_FLAT = 5000;

    /**
     * Muestra la factura del último pedido colocado (usando la sesión).
     */
    public function index()
    {
        // Traer el ID del pedido desde sesión
        $pedidoId = session('pedido_id');

        if (empty($pedidoId)) {
            return redirect()
                ->route('carrito.index')
                ->with('error', 'No hay pedido para mostrar en la factura.');
        }

        // Buscar el pedido con sus relaciones
        $pedido = Pedido::with(['detalles.producto', 'user'])->find($pedidoId);

        if (!$pedido) {
            return redirect()
                ->route('carrito.index')
                ->with('error', 'Pedido no encontrado.');
        }

        // Autorización: el pedido debe pertenecer al usuario logueado
        if ((int)$pedido->user_id !== (int)Auth::id()) {
            abort(403, 'No tienes permiso para ver esta factura.');
        }

        // Cálculos de importes
        $subtotal = $pedido->detalles->sum('subtotal');
        $impuesto = $subtotal * self::TAX_RATE;
        $envio    = self::ENVIO_FLAT;
        $total    = $pedido->total; // Se respeta el total guardado en el pedido

        // Datos de factura
        $facturaId    = 'FAC-' . $pedido->id . '-' . time();
        $fechaCompra  = optional($pedido->fecha_pedido)->format('d M Y');

        // Renderizar vista
        return view('factura', [
            'pedido'     => $pedido,
            'subtotal'   => $subtotal,
            'impuesto'   => $impuesto,
            'envio'      => $envio,
            'total'      => $total,
            'facturaId'  => $facturaId,
            'fechaCompra'=> $fechaCompra,
        ]);
    }
}
