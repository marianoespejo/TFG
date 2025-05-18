<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $fillable = ['usuario_id', 'correo', 'direccion', 'productos', 'total', 'estado'];
    protected $casts = ['productos' => 'array'];

    public function usuario()
    {
        return $this->belongsTo(\App\Models\User::class, 'usuario_id');
    }
}
