<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>ESMO | Nuevo producto</title>
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

        .boton-volver {
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

        .boton-volver:hover {
            background-color: #eee;
        }

        form {
            background-color: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
            max-width: 600px;
            margin: 0 auto;
        }

        label {
            display: block;
            margin-top: 18px;
            margin-bottom: 6px;
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
        }

        button {
            margin-top: 25px;
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
    </style>
</head>
<body>

    <!-- CABECERA CON LOGO Y TEXTO -->
    <div class="barra-header">
        <img src="{{ asset('imagenes/logo-esmo.png') }}" alt="ESMO Logo">
        <h1>Añadir nuevo producto</h1>
    </div>

    <a href="{{ route('admin.index') }}" class="boton-volver">← Volver</a>

    <form action="{{ route('admin.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" required>

        <label for="descripcion">Descripción</label>
        <textarea name="descripcion" rows="3"></textarea>

        <label for="categoria">Categoría</label>
        <select name="categoria" required>
            <option value="pulsera">Pulsera</option>
            <option value="collar">Collar</option>
            <option value="pendiente">Pendiente</option>
        </select>

        <label for="precio">Precio (€)</label>
        <input type="number" name="precio" step="0.01" required>

        <label for="stock">Stock</label>
        <input type="number" name="stock" required>

        <label for="imagen">Imagen</label>
        <input type="file" name="imagen">

        <button type="submit">Guardar producto</button>
    </form>

</body>
</html>
