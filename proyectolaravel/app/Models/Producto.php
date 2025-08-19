<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'descripcion', 'precio', 'imagen_url'];

    // Relación con los detalles del carrito
    public function detallesCarrito()
    {
        return $this->hasMany(DetalleCarrito::class, 'producto_id');
    }
}
