<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $fillable = ['usuario_id', 'correo', 'productos', 'total', 'estado'];
    protected $casts = ['productos' => 'array'];
}
