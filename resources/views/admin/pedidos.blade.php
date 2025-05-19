<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>ESMO | Gestión de Pedidos</title>
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

        .boton-cambio {
            background-color: #555;
            color: white;
            padding: 10px 20px;
            border-radius: 30px;
            text-decoration: none;
            font-size: 14px;
            margin-top: 10px;
            margin-bottom: 30px;
            display: inline-block;
            transition: background-color 0.3s ease;
        }

        .boton-cambio:hover {
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
            vertical-align: top;
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
    </style>
</head>
<body>

    <div class="barra-header">
        <img src="{{ asset('imagenes/logo-esmo.png') }}" alt="ESMO Logo">
        <h1>Gestión de Pedidos</h1>
    </div>

    <a href="{{ route('admin.index') }}" class="boton-cambio">📦 Ver productos</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Email</th>
                <th>Dirección</th>
                <th>Productos</th>
                <th>Total (€)</th>
                <th>Estado</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pedidos as $pedido)
                <tr>
                    <td>{{ $pedido->id }}</td>
                    <td>
                        @if ($pedido->usuario)
                            {{ $pedido->usuario->nombre }}
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $pedido->correo ?? '-' }}</td>
                    <td>{{ $pedido->direccion ?? '-' }}</td>
                    <td>
                        @foreach ($pedido->productos as $producto)
                            ID: {{ $producto['id'] }} (x{{ $producto['cantidad'] }})<br>
                        @endforeach
                    </td>
                    <td>{{ number_format($pedido->total, 2, ',', '.') }}</td>
                    <td>{{ ucfirst($pedido->estado) }}</td>
                    <td>{{ $pedido->created_at->format('d/m/Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
