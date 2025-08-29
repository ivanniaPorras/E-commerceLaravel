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
        
        // Después de procesar el pago, redirige al usuario a la página de éxito
        return redirect()->route('pago.index');
    }
}
