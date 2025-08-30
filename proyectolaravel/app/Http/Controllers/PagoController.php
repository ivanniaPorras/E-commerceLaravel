<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Pedido;
use App\Models\DetallePedido;
use App\Models\Producto;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class PagoController extends Controller
{
    /**
     * Muestra la pantalla de pago si existen datos de checkout en sesión
     */
    public function index()
    {
        $total = session('checkout_total');
        $carrito = session('checkout_carrito');

        if (!$total || !$carrito) {
            return redirect()
                ->route('carrito.index')
                ->with('error', 'No hay datos de checkout, regresa al carrito.');
        }

        return view('pago', [
            'checkoutTotal'   => $total,
            'checkoutCarrito' => $carrito,
        ]);
    }

    /**
     * Crea el PaymentIntent en Stripe
     */
    public function createPaymentIntent(Request $request)
    {
        // Configurar Stripe con la llave secreta
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // El total se obtiene de la sesión
        $total = session('checkout_total', 0);

        // Stripe trabaja en centavos
        $montoCentavos = intval($total * 100);

        $paymentIntent = PaymentIntent::create([
            'amount'   => $montoCentavos,
            'currency' => 'crc',
            'metadata' => [
                'user_id' => Auth::id(),
            ],
        ]);

        return response()->json([
            'clientSecret' => $paymentIntent->client_secret
        ]);
    }

    /**
     * Confirma el pago y genera el pedido en la base de datos
     */
    public function confirmPayment(Request $request)
    {
        $total   = session('checkout_total');
        $carrito = session('checkout_carrito');

        if (!$total || !$carrito) {
            return response()->json([
                'error' => 'No hay datos de checkout'
            ], 400);
        }

        try {
            DB::beginTransaction();

            // Guardar el pedido principal
            $pedido = Pedido::create([
                'user_id'      => Auth::id(),
                'total'        => $total,
                'estado'       => 'pagado',
                'fecha_pedido' => now(),
            ]);

            // Registrar los productos asociados
            foreach ($carrito as $idProducto => $item) {
                DetallePedido::create([
                    'pedido_id'      => $pedido->id,
                    'producto_id'    => $idProducto,
                    'cantidad'       => $item['cantidad'],
                    'precio_unitario'=> $item['precio'],
                    'subtotal'       => $item['cantidad'] * $item['precio'],
                ]);

                // Descontar stock
                $producto = Producto::find($idProducto);
                if ($producto) {
                    $producto->decrement('stock', $item['cantidad']);
                }
            }

            DB::commit();

            // Guardar datos para factura
            session([
                'pedido_id'    => $pedido->id,
                'pedido_total' => $total,
            ]);

            // Limpiar sesión de checkout
            session()->forget([
                'checkout_subtotal',
                'checkout_impuesto',
                'checkout_envio',
                'checkout_total',
                'checkout_carrito'
            ]);

            return response()->json([
                'success'  => true,
                'redirect' => route('factura.index')
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'error' => 'Error al confirmar el pago: ' . $e->getMessage()
            ], 500);
        }
    }
}
