<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class ReporteController extends Controller
{
    public function index()
    {
        // Estadísticas generales
        $totalUsuarios = User::count();
        $totalProductos = Producto::count();
        $totalPedidos = Pedido::count();
        $totalVentas = Pedido::sum('total');

        // Ventas por mes del año actual
        $ventasPorMes = $this->getVentasPorMes();
        
        // Productos más vendidos
        $productosMasVendidos = $this->getProductosMasVendidos();
        
        // Usuarios con más compras
        $usuariosTop = $this->getUsuariosTop();
        
        // Categorías más vendidas
        $categoriasMasVendidas = $this->getCategoriasMasVendidas();

        return view('admin.reports', compact(
            'totalUsuarios',
            'totalProductos', 
            'totalPedidos',
            'totalVentas',
            'ventasPorMes',
            'productosMasVendidos',
            'usuariosTop',
            'categoriasMasVendidas'
        ));
    }

    public function exportarVentasPDF(Request $request)
    {
        $fechaInicio = $request->get('fecha_inicio') ? Carbon::parse($request->get('fecha_inicio')) : Carbon::now()->startOfMonth();
        $fechaFin = $request->get('fecha_fin') ? Carbon::parse($request->get('fecha_fin')) : Carbon::now()->endOfMonth();

        // Obtener pedidos del período
        $pedidos = Pedido::with(['user', 'detalles.producto'])
            ->whereBetween('fecha_pedido', [$fechaInicio, $fechaFin])
            ->orderBy('fecha_pedido', 'desc')
            ->get();

        // Calcular totales
        $totalVentas = $pedidos->sum('total');
        $totalPedidos = $pedidos->count();
        $promedioTicket = $totalPedidos > 0 ? $totalVentas / $totalPedidos : 0;

        // Generar PDF
        $pdf = PDF::loadView('admin.pdf.reporte-ventas', compact(
            'pedidos',
            'fechaInicio',
            'fechaFin',
            'totalVentas',
            'totalPedidos',
            'promedioTicket'
        ));

        $nombreArchivo = 'reporte-ventas-' . $fechaInicio->format('Y-m-d') . '-' . $fechaFin->format('Y-m-d') . '.pdf';
        
        return $pdf->download($nombreArchivo);
    }

    private function getVentasPorMes()
    {
        $currentYear = now()->year;
        $ventas = [];

        for ($i = 1; $i <= 12; $i++) {
            $month = Carbon::createFromDate($currentYear, $i, 1);
            $total = Pedido::whereYear('fecha_pedido', $currentYear)
                          ->whereMonth('fecha_pedido', $i)
                          ->sum('total');
            
            $ventas[] = [
                'mes' => $month->format('M'),
                'total' => $total,
                'cantidad' => Pedido::whereYear('fecha_pedido', $currentYear)
                                   ->whereMonth('fecha_pedido', $i)
                                   ->count()
            ];
        }

        return $ventas;
    }

    private function getProductosMasVendidos()
    {
        return DB::table('detalles_pedido')
            ->join('productos', 'detalles_pedido.producto_id', '=', 'productos.id')
            ->select('productos.nombre', 'productos.categoria', DB::raw('SUM(detalles_pedido.cantidad) as total_vendido'))
            ->groupBy('productos.id', 'productos.nombre', 'productos.categoria')
            ->orderBy('total_vendido', 'desc')
            ->limit(10)
            ->get();
    }

    private function getUsuariosTop()
    {
        return DB::table('pedidos')
            ->join('users', 'pedidos.user_id', '=', 'users.id')
            ->select('users.name', 'users.email', DB::raw('COUNT(pedidos.id) as total_pedidos'), DB::raw('SUM(pedidos.total) as total_gastado'))
            ->groupBy('users.id', 'users.name', 'users.email')
            ->orderBy('total_gastado', 'desc')
            ->limit(10)
            ->get();
    }

    private function getCategoriasMasVendidas()
    {
        return DB::table('detalles_pedido')
            ->join('productos', 'detalles_pedido.producto_id', '=', 'productos.id')
            ->select('productos.categoria', DB::raw('SUM(detalles_pedido.cantidad * detalles_pedido.precio_unitario) as total_ventas'))
            ->groupBy('productos.categoria')
            ->orderBy('total_ventas', 'desc')
            ->get();
    }
}
