<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    /**
     * Muestra el proceso de compra.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Recupera el carrito de la sesión
        $carrito = session()->get('carrito', []);
        
        // Puedes agregar más lógica de negocio si lo deseas, como calcular totales o impuestos.
        
        // Devuelve la vista de checkout con los datos del carrito
        return view('checkout', compact('carrito'));
    }

    /**
     * Procesa el pago.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function process(Request $request)
    {
        // Aquí iría la lógica para procesar el pago (ej. integración con una pasarela de pago como Stripe, PayPal, etc.)
        // Este ejemplo solo redirige a la página de éxito.
        
        // Después de procesar el pago, redirige al usuario a la página de éxito
        return redirect()->route('checkout.success');
    }
}
