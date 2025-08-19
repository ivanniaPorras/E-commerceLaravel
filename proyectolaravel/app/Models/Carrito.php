<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Producto;

class Carrito extends Model
{
    use HasFactory;

    protected $fillable = ['user_id'];

    // Relación con la tabla de productos a través de detalles_carrito
    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'detalles_carrito')
                    ->withPivot('cantidad')
                    ->withTimestamps();
    }

    // Relación con el usuario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relación con los pagos
    public function pagos()
    {
        return $this->hasOne(Pago::class);
    }
}

