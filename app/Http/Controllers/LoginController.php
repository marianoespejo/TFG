<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login'); // La vista que ya preparamos
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate(); // 🔒 Seguridad extra
            return redirect()->route('cliente.tienda'); // 👈 Vuelve a la tienda
        }

        return back()->withErrors([
            'email' => 'El correo o la contraseña son incorrectos.',
        ]);
    }

    public function logout(Request $request)
    {
        // Borrar todas las variables de sesión
        $request->session()->forget(['usuario_id', 'usuario_nombre', 'usuario_rol']);

        // O también puedes hacer: $request->session()->flush();

        return redirect()->route('cliente.tienda');
    }
}
