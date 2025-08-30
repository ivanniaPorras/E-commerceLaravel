<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Pedido;
use App\Models\DetallePedido;
use App\Models\Producto;
use App\Models\Carrito;


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
        // Simular creación de PaymentIntent 
        $checkoutTotal = session('checkout_total', 0);
        
        // Generar un ID ficticio de transacción
        $fakeTransactionId = 'TXN_' . time() . '_' . rand(1000, 9999);
        
        return response()->json([
            'clientSecret' => $fakeTransactionId,
            'message' => 'PaymentIntent simulado exitosamente'
        ]);
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
                'estado' => 'pagado',
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

            // LIMPIAR EL CARRITO DE LA BASE DE DATOS
            $this->limpiarCarrito();

            // Limpiar datos de checkout
            session()->forget(['checkout_subtotal', 'checkout_impuesto', 'checkout_envio', 'checkout_total', 'checkout_carrito']);

            // Redirigir a la factura
            return response()->json(['success' => true, 'redirect' => route('factura.index')]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Error al confirmar el pago: ' . $e->getMessage()], 500);
        }
    }

    // Método privado para limpiar el carrito
    private function limpiarCarrito()
    {
        $carrito = Carrito::where('user_id', Auth::id())->first();
        
        if ($carrito) {
            // Eliminar todos los productos del carrito
            $carrito->productos()->detach();
            
            // También limpiar la sesión del carrito
            session()->forget(['carrito']);
        }
    }
}
