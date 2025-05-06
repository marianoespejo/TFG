<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function mostrarLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            session([
                'usuario_id' => $user->id,
                'usuario_nombre' => $user->nombre,
                'usuario_rol' => $user->rol,
            ]);

            if ($user->rol === 'admin') {
                return redirect()->route('admin.index');
            } else {
                return redirect()->route('cliente.tienda');
            }
        }

        return back()->withErrors([
            'email' => 'Email o contraseña incorrectos.',
        ]);
    }

    public function mostrarRegistro()
    {
        return view('auth.register');
    }

    public function registrar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol' => 'cliente', // 👈 todos empiezan como cliente
        ]);

        // Logueamos manualmente
        session([
            'usuario_id' => $user->id,
            'usuario_nombre' => $user->nombre,
            'usuario_rol' => $user->rol,
        ]);

        return redirect()->route('cliente.tienda');
    }

    public function logout(Request $request)
    {
        session()->flush();
        return redirect()->route('cliente.tienda');
    }
}
