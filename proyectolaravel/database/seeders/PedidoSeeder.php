<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pedido;
use App\Models\DetallePedido;
use App\Models\User;
use App\Models\Producto;
use Carbon\Carbon;

class PedidoSeeder extends Seeder
{
    
    public function run(): void
    {
        $users = User::all();
        $productos = Producto::all();

        if ($users->isEmpty() || $productos->isEmpty()) {
            return;
        }

        // Crear pedidos de prueba para el último mes
        for ($i = 0; $i < 15; $i++) {
            $user = $users->random();
            $fecha = Carbon::now()->subDays(rand(1, 30));
            
            $pedido = Pedido::create([
                'user_id' => $user->id,
                'total' => 0,
                'estado' => ['pendiente', 'procesando', 'enviado', 'entregado', 'cancelado'][rand(0, 4)],
                'fecha_pedido' => $fecha
            ]);

            $total = 0;
            $numProductos = rand(1, 3);
            
            for ($j = 0; $j < $numProductos; $j++) {
                $producto = $productos->random();
                $cantidad = rand(1, 5);
                $precio = $producto->precio;
                $subtotal = $cantidad * $precio;
                
                DetallePedido::create([
                    'pedido_id' => $pedido->id,
                    'producto_id' => $producto->id,
                    'cantidad' => $cantidad,
                    'precio_unitario' => $precio,
                    'subtotal' => $subtotal
                ]);
                
                $total += $subtotal;
            }
            
            $pedido->update(['total' => $total]);
        }
    }
}
