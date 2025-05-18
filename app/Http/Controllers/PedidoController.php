<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class PedidoController extends Controller
{
    public function confirmarVista(Request $request)
    {
        $usuario = null;
        if (session('usuario_id')) {
            $usuario = \App\Models\User::find(session('usuario_id'));
        }

        return view('confirmar', compact('usuario'));
    }

    public function guardarDatosYRedirigir(Request $request)
    {
        $request->validate([
            'direccion' => 'required|string',
            'correo' => session('usuario_id') ? 'nullable' : 'required|email',
        ]);

        // Guardar dirección en sesión para el pedido
        session([
            'datos_pedido' => [
                'direccion' => $request->direccion,
                'correo' => $request->correo,
            ]
        ]);

        // Si está logueado, actualizar dirección en la tabla users
        if (session('usuario_id')) {
            $usuario = \App\Models\User::find(session('usuario_id'));
            if ($usuario) {
                $usuario->direccion = $request->direccion;
                $usuario->save();
            }
        }

        return redirect()->route('pago.formulario');
    }

}
