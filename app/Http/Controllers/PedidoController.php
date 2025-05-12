<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PedidoController extends Controller
{
    public function realizar(Request $request)
    {
        $request->validate([
            'productos' => 'required|array',
            'productos.*.id' => 'required|integer',
            'productos.*.cantidad' => 'required|integer|min:1',
            'total' => 'required|numeric|min:0',
            'correo' => 'nullable|email',
        ]);

        $pedido = Pedido::create([
            'usuario_id' => session('usuario_id'),
            'correo' => session('usuario_id') ? null : $request->correo,
            'productos' => $request->productos,
            'total' => $request->total,
            'estado' => 'pendiente',
        ]);

        // Enviar correo si es no registrado
        if (!$pedido->usuario_id && $pedido->correo) {
            Mail::raw("Gracias por tu compra. Detalles: " . json_encode($pedido->productos), function($m) use ($pedido) {
                $m->to($pedido->correo)->subject('Resumen de tu pedido ESMA');
            });
        }

        return response()->json(['success' => true]);
    }

}
