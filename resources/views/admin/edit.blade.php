<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar producto | ESMO</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f7f4f2;
            margin: 0;
            padding: 40px;
            color: #333;
        }

        .barra-header {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 30px;
        }

        .barra-header img {
            height: 70px;
        }

        .barra-header h1 {
            font-size: 26px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin: 0;
            color: #c2185b;
        }

        .volver {
            display: inline-block;
            margin-bottom: 20px;
            padding: 10px 20px;
            background-color: transparent;
            border: 1px solid #aaa;
            border-radius: 25px;
            text-decoration: none;
            color: #333;
            font-size: 14px;
            transition: all 0.2s ease;
        }

        .volver:hover {
            background-color: #eee;
        }

        form {
            background-color: white;
            padding: 30px;
            border-radius: 12px;
            max-width: 600px;
            margin: 0 auto;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        label {
            display: block;
            margin-top: 20px;
            font-weight: 500;
        }

        input[type="text"],
        input[type="number"],
        textarea,
        select {
            width: 100%;
            padding: 12px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 15px;
            margin-top: 5px;
        }

        button {
            margin-top: 30px;
            background-color: black;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 25px;
            font-size: 15px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #333;
        }

        .imagen-actual {
            margin-top: 20px;
            text-align: center;
        }

        .imagen-actual img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            border: 1px solid #ccc;
        }
    </style>
</head>
<body>

    <!-- CABECERA CON LOGO Y TEXTO -->
    <div class="barra-header">
        <img src="{{ asset('imagenes/logo-esmo.png') }}" alt="ESMO Logo">
        <h1>Editar producto</h1>
    </div>

    <a href="{{ route('admin.index') }}" class="volver">← Volver</a>

    <form action="{{ route('admin.update', $producto->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" value="{{ old('nombre', $producto->nombre) }}" required>

        <label for="descripcion">Descripción</label>
        <textarea name="descripcion" rows="3">{{ old('descripcion', $producto->descripcion) }}</textarea>

        <label for="categoria">Categoría</label>
        <select name="categoria" required>
            <option value="pulsera" {{ $producto->categoria == 'pulsera' ? 'selected' : '' }}>Pulsera</option>
            <option value="collar" {{ $producto->categoria == 'collar' ? 'selected' : '' }}>Collar</option>
            <option value="pendiente" {{ $producto->categoria == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
        </select>

        <label for="precio">Precio (€)</label>
        <input type="number" name="precio" step="0.01" value="{{ old('precio', $producto->precio) }}" required>

        <label for="stock">Stock</label>
        <input type="number" name="stock" value="{{ old('stock', $producto->stock) }}" required>

        <label for="imagen">Nueva imagen (opcional)</label>
        <input type="file" name="imagen">

        @if($producto->imagen)
            <div class="imagen-actual">
                <p>Imagen actual:</p>
                <img src="{{ asset('imagenes/' . $producto->imagen) }}" alt="Imagen actual">
            </div>
        @endif

        <button type="submit">Actualizar producto</button>
    </form>

</body>
</html>
