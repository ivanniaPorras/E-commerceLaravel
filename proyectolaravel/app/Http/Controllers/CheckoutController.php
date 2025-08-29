<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    /**
     * Muestra el proceso de compra.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Debug temporal
        Log::info('Accediendo al checkout');
        
        // Verificar que el usuario esté autenticado
        if (!Auth::check()) {
            Log::info('Usuario no autenticado, redirigiendo a login');
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para continuar.');
        }

        Log::info('Usuario autenticado: ' . Auth::id());

        // Recupera el carrito de la sesión
        $carrito = session()->get('carrito', []);
        
        Log::info('Carrito en sesión: ' . json_encode($carrito));
        
        if (empty($carrito)) {
            Log::info('Carrito vacío, redirigiendo a carrito');
            return redirect()->route('carrito.index')->with('error', 'Tu carrito está vacío.');
        }

        // Calcular totales
        $subtotal = 0;
        foreach ($carrito as $item) {
            $subtotal += $item['precio'] * $item['cantidad'];
        }

        $impuesto = $subtotal * 0.13;
        $envio = 5000;
        $total = $subtotal + $impuesto + $envio;

        Log::info('Totales calculados - Subtotal: ' . $subtotal . ', Total: ' . $total);

        // Devuelve la vista de checkout con los datos del carrito
        return view('checkout', compact('carrito', 'subtotal', 'impuesto', 'envio', 'total'));
    }

    /**
     * Procesa el checkout y redirige a pago.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function process(Request $request)
    {
        // Verificar que el usuario esté autenticado
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para continuar.');
        }

        // Validar los datos del formulario
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:500',
            'payment_method' => 'required|string|in:credit_card,paypal,bank_transfer'
        ]);

        // Recuperar el carrito de la sesión
        $carrito = session()->get('carrito', []);
        
        if (empty($carrito)) {
            return redirect()->route('carrito.index')->with('error', 'Tu carrito está vacío.');
        }

        // Calcular totales
        $subtotal = 0;
        foreach ($carrito as $item) {
            $subtotal += $item['precio'] * $item['cantidad'];
        }

        $impuesto = $subtotal * 0.13;
        $envio = 5000;
        $total = $subtotal + $impuesto + $envio;

        // Guardar datos del formulario y totales en sesión para el pago
        session([
            'checkout_name' => $request->name,
            'checkout_email' => $request->email,
            'checkout_address' => $request->address,
            'checkout_payment_method' => $request->payment_method,
            'checkout_subtotal' => $subtotal,
            'checkout_impuesto' => $impuesto,
            'checkout_envio' => $envio,
            'checkout_total' => $total,
            'checkout_carrito' => $carrito
        ]);

        // Redirigir a la página de pago
        return redirect()->route('pago.index')->with('success', 'Datos de checkout guardados. Procede con el pago.');
    }
}
