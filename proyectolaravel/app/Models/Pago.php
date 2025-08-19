<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;

    protected $fillable = ['carrito_id', 'metodo_pago', 'monto', 'estado'];

    // Relación con el carrito
    public function carrito()
    {
        return $this->belongsTo(Carrito::class, 'carrito_id');
    }
}

