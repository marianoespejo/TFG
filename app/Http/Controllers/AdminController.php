<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Pedido;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        $productos = Producto::all();
        return view('admin.index', compact('productos'));
    }

    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'precio' => 'required|numeric',
            'descripcion' => 'required',
            'stock' => 'required|integer',
            'categoria' => 'required',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $datos = $request->except('_token');

        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('imagenes'), $filename);
            $datos['imagen'] = $filename;
        }

        Producto::create($datos);

        return redirect()->route('admin.index');
    }

    public function edit(Producto $producto)
    {
        return view('admin.edit', compact('producto'));
    }

    public function update(Request $request, Producto $producto)
    {
        $request->validate([
            'nombre' => 'required',
            'precio' => 'required|numeric',
            'stock' => 'required|integer',
            'categoria' => 'required',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $datos = $request->except(['_token', '_method']);

        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('imagenes'), $filename);
            $datos['imagen'] = $filename;
        }

        $producto->update($datos);

        return redirect()->route('admin.index');
    }

    public function destroy(Producto $producto)
    {
        $producto->delete();
        return redirect()->route('admin.index');
    }

    public function verPedidos()
    {
        $pedidos = Pedido::with('usuario')->orderByDesc('created_at')->get();
        return view('admin.pedidos', compact('pedidos'));
    }
}
