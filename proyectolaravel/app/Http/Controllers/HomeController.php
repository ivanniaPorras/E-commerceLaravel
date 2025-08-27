<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Producto::query();

        // Filtro por nombre
        if ($request->filled('nombre')) {
            $query->where('nombre', 'like', '%' . $request->nombre . '%');
        }

        // Filtro por categoría
        if ($request->filled('categoria')) {
            $query->where('categoria', $request->categoria);
        }

        // Filtro por precio mínimo
        if ($request->filled('precio_min')) {
            $query->where('precio', '>=', $request->precio_min);
        }

        // Filtro por precio máximo
        if ($request->filled('precio_max')) {
            $query->where('precio', '<=', $request->precio_max);
        }

        $productos = $query->get();

        return view('home', compact('productos'));
    }
}
