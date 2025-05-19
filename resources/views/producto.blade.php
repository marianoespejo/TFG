<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>{{ $producto->nombre }} | ESMO</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #fff;
            margin: 0;
            padding: 40px;
            color: #111;
        }

        .contenedor-producto {
            display: flex;
            max-width: 1200px;
            margin: auto;
            gap: 50px;
        }

        .contenedor-producto img {
            width: 500px;
            border-radius: 12px;
        }

        .info {
            flex: 1;
        }

        .precio {
            font-size: 24px;
            color: #c2185b;
            margin-bottom: 20px;
        }

        .descripcion {
            margin-bottom: 20px;
        }

        input[type="number"] {
            width: 70px;
            margin-top: 10px;
            margin-bottom: 20px;
        }

        button {
            background-color: black;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 25px;
            font-size: 15px;
            cursor: pointer;
        }

        a.volver {
            display: block;
            margin-bottom: 30px;
            text-decoration: none;
            color: #333;
        }
    </style>
</head>
<body>

    <a href="{{ route('cliente.tienda') }}" class="volver">← Volver a la tienda</a>

    <div class="contenedor-producto">
        <img src="{{ asset('imagenes/' . $producto->imagen) }}" alt="{{ $producto->nombre }}">

        <div class="info">
            <h1>{{ $producto->nombre }}</h1>
            <div class="precio">€{{ number_format($producto->precio, 2, ',', '.') }}</div>
            <div class="descripcion">{{ $producto->descripcion }}</div>

            <label for="cantidad">Cantidad:</label>
            <input type="number" id="cantidad" value="1" min="1">

            <button onclick="agregarAlCarritoProducto({{ $producto->id }})">Añadir al carrito</button>
        </div>
    </div>

    <script>
        function agregarAlCarritoProducto(id) {
            const cantidad = parseInt(document.getElementById('cantidad').value);
            let carrito = JSON.parse(localStorage.getItem('carrito')) || [];

            const existente = carrito.find(p => p.id === id);
            if (existente) {
                existente.cantidad += cantidad;
            } else {
                carrito.push({ id, cantidad });
            }

            localStorage.setItem('carrito', JSON.stringify(carrito));
            alert("Producto añadido al carrito.");
        }
    </script>

</body>
</html>
