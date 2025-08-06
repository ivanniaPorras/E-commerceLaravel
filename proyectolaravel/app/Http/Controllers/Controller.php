<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function index()
    {
        // Aquí puedes obtener los datos del carrito, usuario, o lo que sea necesario para el proceso de compra
        return view('checkout'); // Esto cargará la vista 'checkout.blade.php'
    }
}
