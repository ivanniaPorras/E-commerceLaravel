<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    // Mostrar todos los productos
    public function index()
    {
        // Obtener todos los productos de la base de datos
        $productos = Producto::all();

        // Pasar los productos a la vista
        return view('home', compact('productos'));
    }
}