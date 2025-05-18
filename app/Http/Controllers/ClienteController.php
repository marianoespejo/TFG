<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\User;

class ClienteController extends Controller
{
    // MOSTRAR TODOS LOS PRODUCTOS CON BUSCADOR Y FILTRO
    public function tienda(Request $request)
    {
        $query = Producto::query();

        // Filtro de búsqueda
        if ($request->filled('buscar')) {
            $query->where('nombre', 'like', '%' . $request->buscar . '%');
        }

        // Filtro por categoría
        if ($request->filled('categoria')) {
            $query->where('categoria', $request->categoria);
        }

        $productos = $query->get();

        return view('tienda', compact('productos'));
    }

    // MOSTRAR UN PRODUCTO INDIVIDUAL
    public function mostrar(Producto $producto)
    {
        return view('producto', compact('producto'));
    }

    // Mostrar formulario de registro
    public function registerForm()
    {
        return view('auth.register');
    }

    // Procesar el registro
    public function register(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'rol' => 'cliente',
        ]);

        session([
            'usuario_id' => $user->id,
            'usuario_nombre' => $user->nombre,
            'usuario_rol' => $user->rol,
        ]);

        return redirect()->route('cliente.tienda');
    }

    // Mostrar formulario de login
    public function loginForm()
    {
        return view('auth.login');
    }

    // Procesar login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && \Hash::check($request->password, $user->password)) {
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
            'email' => 'Credenciales incorrectas.',
        ]);
    }

    // Cerrar sesión
    public function logout()
    {
        session()->flush();
        return redirect()->route('cliente.tienda');
    }

    public function misPedidos()
    {
        $usuarioId = session('usuario_id');
        $pedidos = \App\Models\Pedido::where('usuario_id', $usuarioId)->get();
        return view('misPedidos', compact('pedidos'));
    }

    public function miInformacion()
    {
        $usuario = \App\Models\User::find(session('usuario_id'));

        if (!$usuario) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión.');
        }

        return view('miInformacion', compact('usuario'));
    }
    public function actualizarInformacion(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . session('usuario_id'),
            'direccion' => 'required|string|max:255',
            'password' => 'nullable|string|min:6',
        ]);

        $usuario = User::find(session('usuario_id'));

        if (!$usuario) {
            return redirect()->back()->with('error', 'Usuario no encontrado');
        }

        $usuario->nombre = $request->nombre;
        $usuario->email = $request->email;
        $usuario->direccion = $request->direccion;

        if ($request->filled('password')) {
            $usuario->password = Hash::make($request->password);
        }

        $usuario->save();

        return redirect()->back()->with('success', 'Información actualizada correctamente');
    }

}
