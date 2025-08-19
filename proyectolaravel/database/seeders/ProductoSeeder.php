<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Producto;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Crear productos en la base de datos
        Producto::create([
            'nombre' => 'Miel Orgánica Pura',
            'descripcion' => 'Endulzante natural sin aditivos, rica en antioxidantes.',
            'precio' => 6600,
            'categoria' => 'Endulzantes',
            'imagen_url' => 'ProductoMiel.png',  // Ruta de la imagen en storage
            'stock' => 100,  
        ]);

        Producto::create([
            'nombre' => 'Aceite de Coco Virgen',
            'descripcion' => 'Prensado en frío, ideal para cocina y cuidado personal.',
            'precio' => 5200,
            'categoria' => 'Aceites',
            'imagen_url' => 'ProductoAceiteCoco.png',
            'stock' => 50,  
        ]);

        Producto::create([
            'nombre' => 'Quinoa Real',
            'descripcion' => 'Grano sin gluten, alto en proteína y fibra.',
            'precio' => 3550,
            'categoria' => 'Granos',
            'imagen_url' => 'ProductoQuinoa.png',
            'stock' => 30,  
        ]);

        Producto::create([
            'nombre' => 'Granola Sin Azúcar',
            'descripcion' => 'A base de avena, frutos secos y dátiles.',
            'precio' => 2850,
            'categoria' => 'Cereales',
            'imagen_url' => 'ProductoGranola.png',
            'stock' => 70,  
        ]);

        Producto::create([
            'nombre' => 'Kombucha de Jengibre',
            'descripcion' => 'Bebida probiótica fermentada y refrescante.',
            'precio' => 1700,
            'categoria' => 'Bebidas',
            'imagen_url' => 'ProductoKombucha.png',
            'stock' => 120,  
        ]);

        Producto::create([
            'nombre' => 'Té Verde Matcha',
            'descripcion' => 'Polvo fino, alto en antioxidantes y energía natural.',
            'precio' => 7900,
            'categoria' => 'Tés',
            'imagen_url' => 'ProductoMatcha.png',
            'stock' => 80,  
        ]);

        Producto::create([
            'nombre' => 'Harina de Almendra',
            'descripcion' => 'Alternativa sin gluten para repostería saludable.',
            'precio' => 4000,
            'categoria' => 'Harinas',
            'imagen_url' => 'ProductoHarina.png',
            'stock' => 90,  
        ]);

        Producto::create([
            'nombre' => 'Leche de Avena',
            'descripcion' => 'Bebida vegetal cremosa y sin lactosa.',
            'precio' => 1550,
            'categoria' => 'Bebidas Vegetales',
            'imagen_url' => 'ProductoLeche.png',
            'stock' => 200,  
        ]);

        Producto::create([
            'nombre' => 'Chips de Kale',
            'descripcion' => 'Crujientes, horneadas y sazonadas naturalmente.',
            'precio' => 2200,
            'categoria' => 'Snacks',
            'imagen_url' => 'ProductoKale.png',
            'stock' => 150,  
        ]);

        Producto::create([
            'nombre' => 'Semillas de Chía',
            'descripcion' => 'Ricas en omega-3 y fibra, perfectas para puddings.',
            'precio' => 1900,
            'categoria' => 'Semillas',
            'imagen_url' => 'ProductoChia.png',
            'stock' => 60,  
        ]);
    }
}
