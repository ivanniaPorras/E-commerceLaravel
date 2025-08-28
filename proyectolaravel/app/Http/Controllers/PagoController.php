<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;  

class PagoController extends Controller
{
    public function index()
    {
        return view('pago');
    }

    public function createPaymentIntent(Request $request)
    {
        // Configurar Stripe
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // Crear PaymentIntent
        $paymentIntent = PaymentIntent::create([  
            'amount' => 1000,  
            'currency' => 'usd',  
            'metadata' => ['integration_check' => 'accept_a_payment'],
        ]);

        return response()->json(['clientSecret' => $paymentIntent->client_secret]);
    }
}
