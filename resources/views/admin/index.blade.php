<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>ESMA | Administración de Productos</title>
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
            border: none;
        }

        .barra-header h1 {
            font-size: 26px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin: 0;
            color: #000;
        }

        .boton-crear {
            background-color: black;
            color: white;
            padding: 12px 24px;
            border-radius: 30px;
            text-decoration: none;
            display: inline-block;
            margin-bottom: 30px;
            font-size: 15px;
            transition: background-color 0.3s ease;
        }

        .boton-crear:hover {
            background-color: #333;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background-color: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
            border-radius: 12px;
            overflow: hidden;
        }

        thead {
            background-color: #f2f2f2;
        }

        th, td {
            padding: 18px;
            text-align: center;
            font-size: 15px;
            border-bottom: 1px solid #eee;
            vertical-align: top; /* 👈 importante: Alinear todo arriba */
        }

        th {
            color: #666;
            font-weight: 500;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover {
            background-color: #fdf8f6;
        }

        img {
            width: 70px;
            height: auto;
            border-radius: 8px;
        }

        .acciones {
            display: flex;
            flex-direction: column; /* 👈 Botones uno debajo del otro */
            gap: 10px;
            align-items: center;
        }

        .acciones a {
            background-color: #d4f5d4;
            color: #215e21;
            border: none;
            padding: 8px 18px;
            border-radius: 30px;
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .acciones a:hover {
            background-color: #b7e9b7;
        }

        .acciones form button {
            background-color: #f8d4d4;
            color: #8b2d2d;
            border: none;
            padding: 8px 18px;
            border-radius: 30px;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .acciones form button:hover {
            background-color: #f2b6b6;
        }

        form {
            display: inline;
        }
    </style>
</head>
<body>

    <div class="barra-header">
        <img src="{{ asset('imagenes/logo-esmo.png') }}" alt="ESMO Logo">
        <h1>Gestión de Productos</h1>
    </div>

    <a href="{{ route('admin.create') }}" class="boton-crear">+ Añadir producto</a>

    <table>
        <thead>
            <tr>
                <th>Imagen</th>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($productos as $producto)
                <tr>
                    <td>
                        @if($producto->imagen)
                            <img src="{{ asset('imagenes/' . $producto->imagen) }}" alt="{{ $producto->nombre }}">
                        @endif
                    </td>
                    <td>{{ $producto->nombre }}</td>
                    <td>{{ ucfirst($producto->categoria) }}</td>
                    <td>{{ $producto->descripcion }}</td>
                    <td>€{{ number_format($producto->precio, 2, ',', '.') }}</td>
                    <td>{{ $producto->stock }}</td>
                    <td class="acciones">
                        <a href="{{ route('admin.edit', $producto->id) }}">Editar</a>
                        <form action="{{ route('admin.destroy', $producto->id) }}" method="POST" onsubmit="return confirm('¿Seguro que quieres eliminar este producto?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
