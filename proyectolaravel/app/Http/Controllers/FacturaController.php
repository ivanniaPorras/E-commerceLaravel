<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use PDF; // Asegúrate de tener instalada la librería de PDF

class FacturaController extends Controller
{
    public function index()
    {
        // Obtener los datos del carrito de compras desde la sesión
        $carrito = Session::get('carrito', []);
        
        // Calcular los totales
        $total = 0;
        foreach ($carrito as $item) {
            $total += $item['precio'] * $item['cantidad'];
        }

        // Calcular impuestos y envío
        $impuesto = $total * 0.13; // 13% de impuesto
        $envio = 5000; // Costo fijo de envío
        $totalConImpuesto = $total + $impuesto + $envio;

        // Generar un ID único para la compra
        $orderId = 'ORD-' . time() . '-' . rand(1000, 9999);

        // Fecha de compra
        $fechaCompra = now()->format('d M Y');

        // Pasar los datos a la vista
        return view('factura', compact('carrito', 'total', 'impuesto', 'envio', 'totalConImpuesto', 'orderId', 'fechaCompra'));
    }

    public function generatePDF(Request $request)
    {
        // Obtener los datos del carrito de compras desde la sesión
        $carrito = Session::get('carrito', []);
        
        // Calcular los totales
        $total = 0;
        foreach ($carrito as $item) {
            $total += $item['precio'] * $item['cantidad'];
        }

        // Calcular impuestos y envío
        $impuesto = $total * 0.13; // 13% de impuesto
        $envio = 5000; // Costo fijo de envío
        $totalConImpuesto = $total + $impuesto + $envio;

        // Generar un ID único para la compra
        $orderId = 'ORD-' . time() . '-' . rand(1000, 9999);

        // Fecha de compra
        $fechaCompra = now()->format('d M Y');

        // Usar la librería de PDF (puedes usar dompdf o cualquier otra librería compatible con Laravel)
        $pdf = PDF::loadView('factura', compact('carrito', 'total', 'impuesto', 'envio', 'totalConImpuesto', 'orderId', 'fechaCompra'));
        
        // Generar y descargar el PDF
        return $pdf->download('factura_' . $orderId . '.pdf');
    }
}
