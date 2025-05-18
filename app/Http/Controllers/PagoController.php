<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;
use App\Models\Pedido;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class PagoController extends Controller
{
    public function form()
    {
        return view('pago');
    }

    public function procesar(Request $request)
    {
        $request->validate([
            'stripeToken' => 'required',
            'productos' => 'required',
            'total' => 'required|numeric|min:1',
            'correo' => session('usuario_id') ? 'nullable' : 'required|email',
        ]);

        $productos = json_decode($request->productos, true);
        $datos = session('datos_pedido', []);

        $direccion = $datos['direccion'] ?? null;
        $correo = $datos['correo'] ?? $request->correo;

        // Si el usuario está logueado, usamos sus datos
        if (session('usuario_id')) {
            $usuario = User::find(session('usuario_id'));
            if ($usuario) {
                $correo = $usuario->email;
                $direccion = $usuario->direccion ?? $direccion; // Usa la dirección del usuario si existe
            }
        }

        // Validar que haya dirección (evita fallo SQL)
        if (!$direccion) {
            return back()->with('error', 'Debes introducir una dirección de envío.');
        }

        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            Charge::create([
                'amount' => intval($request->total * 100),
                'currency' => 'eur',
                'source' => $request->stripeToken,
                'description' => 'Pago en ESMA',
            ]);
        } catch (\Exception $e) {
            return back()->with('error', 'Error en el pago: ' . $e->getMessage());
        }

        $pedido = Pedido::create([
            'usuario_id' => session('usuario_id'),
            'correo' => $correo,
            'direccion' => $direccion,
            'productos' => $productos,
            'total' => $request->total,
            'estado' => 'aceptado',
        ]);

        foreach ($productos as $p) {
            $producto = Producto::find($p['id']);
            if ($producto) {
                if ($producto->stock >= $p['cantidad']) {
                    $producto->stock -= $p['cantidad'];
                    $producto->save();
                } else {
                    return back()->with('error', "No hay stock suficiente de {$producto->nombre}.");
                }
            }
        }

        if ($correo) {
            $detalle = '';
            foreach ($productos as $p) {
                $producto = Producto::find($p['id']);
                $nombre = $producto ? $producto->nombre : 'Producto';
                $detalle .= "$nombre x{$p['cantidad']}\n";
            }

            Mail::raw(
                "Gracias por tu compra en ESMA 💎\n\nTu pedido:\n" . $detalle .
                "\nDirección: $direccion\nTotal: €" . number_format($pedido->total, 2, ',', '.'),
                function ($m) use ($pedido) {
                    $m->to($pedido->correo)->subject('Resumen de tu pedido ESMA');
                }
            );
        }

        session()->forget('datos_pedido');
        return redirect()->route('cliente.tienda')->with('success', 'Pago realizado y pedido confirmado');
    }
}
