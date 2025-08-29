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
    public function index()
    {
        // Verificar que haya datos de checkout en sesión
        $checkoutTotal = session('checkout_total');
        $checkoutCarrito = session('checkout_carrito');
        
        if (!$checkoutTotal || !$checkoutCarrito) {
            return redirect()->route('carrito.index')->with('error', 'No hay datos de checkout. Regresa al carrito.');
        }

        return view('pago', compact('checkoutTotal', 'checkoutCarrito'));
    }

    public function createPaymentIntent(Request $request)
    {
        // Configurar Stripe
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // Obtener el total del checkout desde la sesión
        $checkoutTotal = session('checkout_total', 0);
        
        // Convertir a centavos para Stripe (asumiendo que el total está en colones)
        $amountInCents = (int)($checkoutTotal * 100);

        // Crear PaymentIntent
        $paymentIntent = PaymentIntent::create([  
            'amount' => $amountInCents,  
            'currency' => 'crc',  // Cambiar a colones costarricenses
            'metadata' => [
                'user_id' => Auth::id(),
            ],
        ]);

        return response()->json(['clientSecret' => $paymentIntent->client_secret]);
    }

    public function confirmPayment(Request $request)
    {
        try {
            // Verificar que haya datos de checkout en sesión
            $checkoutTotal = session('checkout_total');
            $checkoutCarrito = session('checkout_carrito');
            
            if (!$checkoutTotal || !$checkoutCarrito) {
                return response()->json(['error' => 'No hay datos de checkout'], 400);
            }

            // Crear el pedido en la base de datos
            DB::beginTransaction();
            
            $pedido = Pedido::create([
                'user_id' => Auth::id(),
                'total' => $checkoutTotal,
                'estado' => 'pagado', // Estado válido después del pago
                'fecha_pedido' => now(),
            ]);

            // Crear los detalles del pedido
            foreach ($checkoutCarrito as $productoId => $item) {
                DetallePedido::create([
                    'pedido_id' => $pedido->id,
                    'producto_id' => $productoId,
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $item['precio'],
                    'subtotal' => $item['precio'] * $item['cantidad'],
                ]);

                // Actualizar stock del producto
                $producto = Producto::find($productoId);
                if ($producto) {
                    $producto->decrement('stock', $item['cantidad']);
                }
            }

            DB::commit();

            // Guardar el ID del pedido en la sesión para la factura
            session(['pedido_id' => $pedido->id]);
            session(['pedido_total' => $checkoutTotal]);

            // Limpiar datos de checkout
            session()->forget(['checkout_subtotal', 'checkout_impuesto', 'checkout_envio', 'checkout_total', 'checkout_carrito']);

            // Redirigir a la factura
            return response()->json(['success' => true, 'redirect' => route('factura.index')]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Error al confirmar el pago: ' . $e->getMessage()], 500);
        }
    }
}
