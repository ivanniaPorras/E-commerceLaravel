<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total',
        'estado',
        'fecha_pedido'
    ];

    protected $casts = [
        'fecha_pedido' => 'datetime',
        'total' => 'decimal:2'
    ];

    // Relación con el usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con los detalles del pedido (si los hay)
    public function detalles()
    {
        return $this->hasMany(DetallePedido::class);
    }
}
