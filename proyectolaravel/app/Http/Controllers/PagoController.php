<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\DetallePedido;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PagoController extends Controller
{
    /**
     * Muestra la pantalla de pago si existen datos de checkout en sesión.
     */
    public function index()
    {
        $checkoutTotal   = session('checkout_total');
        $checkoutCarrito = session('checkout_carrito');

        if (!$checkoutTotal || !$checkoutCarrito) {
            return redirect()
                ->route('carrito.index')
                ->with('error', 'No hay datos de checkout. Regresa al carrito.');
        }

        return view('pago', [
            'checkoutTotal'   => $checkoutTotal,
            'checkoutCarrito' => $checkoutCarrito,
        ]);
    }

    /**
     * Simula la creación de un intento de pago (sin pasarela real).
     * Devuelve un "clientSecret" ficticio para no romper el frontend.
     */
    public function createPaymentIntent(Request $request)
    {
        $checkoutTotal = session('checkout_total', 0);

        if ($checkoutTotal <= 0) {
            return response()->json([
                'error' => 'Monto inválido o no hay datos de checkout.'
            ], 400);
        }

        $fakeClientSecret = 'dummy_secret_' . uniqid();

        return response()->json([
            'clientSecret' => $fakeClientSecret
        ]);
    }

    /**
     * Confirma el pago (simulado) y genera el pedido en la base de datos.
     */
    public function confirmPayment(Request $request)
    {
        $total   = session('checkout_total');
        $carrito = session('checkout_carrito');

        if (!$total || !is_array($carrito) || empty($carrito)) {
            return response()->json([
                'error' => 'No hay datos de checkout'
            ], 400);
        }

        try {
            DB::beginTransaction();

            // Crear el pedido principal (estado en minúsculas para cumplir el CHECK).
            $pedido = Pedido::create([
                'user_id'      => Auth::id(),
                'total'        => $total,
                'estado'       => 'pagado',   // <- importante para SQLite CHECK
                'fecha_pedido' => now(),
            ]);

            // Registrar cada ítem del carrito como detalle del pedido.
            foreach ($carrito as $idProducto => $item) {
                $cantidad = isset($item['cantidad']) ? (int)$item['cantidad'] : 1;
                $precio   = isset($item['precio'])   ? (float)$item['precio']   : 0.0;

                DetallePedido::create([
                    'pedido_id'       => $pedido->id,
                    'producto_id'     => (int)$idProducto,
                    'cantidad'        => $cantidad,
                    'precio_unitario' => $precio,
                    'subtotal'        => $cantidad * $precio,
                ]);

                // Actualizar stock
                if ($cantidad > 0) {
                    $producto = Producto::find((int)$idProducto);
                    if ($producto) {
                        $producto->decrement('stock', $cantidad);
                    }
                }
            }

            DB::commit();

            // Guardar datos para la factura.
            session([
                'pedido_id'    => $pedido->id,
                'pedido_total' => $total,
            ]);

            // Limpiar datos de checkout.
            session()->forget([
                'checkout_subtotal',
                'checkout_impuesto',
                'checkout_envio',
                'checkout_total',
                'checkout_carrito',
            ]);

            return response()->json([
                'success'  => true,
                'redirect' => route('factura.index'),
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Error al confirmar el pago: ' . $e->getMessage()
            ], 500);
        }
    }
}
