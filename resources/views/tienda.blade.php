<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>ESMO | Colección de joyas</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #fffdfd;
            margin: 0;
            padding: 0;
            color: #111;
        }

        /* HEADER NEGRO */
        .barra-navegacion {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 18px 40px;
            background: #111;
            color: white;
        }

        .contenedor-logo .logo {
            height: 70px;
        }

        /* BUSCADOR MÁS PEQUEÑO */
        .contenedor-busqueda {
            flex-grow: 1;
            margin: 0 40px;
        }

        .input-buscar {
            width: 100%;
            padding: 8px 14px;
            font-size: 14px;
            border-radius: 20px;
            border: 1px solid #555;
            background: #f8f8f8;
        }

        .contenedor-acciones {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .boton-nav {
            text-decoration: none;
            color: white;
            font-size: 14px;
            padding: 7px 14px;
            border: 1px solid #444;
            border-radius: 25px;
            background: transparent;
            transition: 0.2s;
        }

        .boton-nav:hover {
            background: #222;
        }

        /* PRODUCTOS */
        .grid-productos {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
            padding: 40px;
            max-width: 1400px;
            margin: auto;
        }

        .producto {
            background: #fff;
            border: 1px solid #eee;
            border-radius: 12px;
            text-align: center;
            padding: 15px;
            transition: 0.3s;
        }

        .producto:hover {
            box-shadow: 0 8px 24px rgba(0,0,0,0.08);
            transform: translateY(-4px);
        }

        .producto img {
            width: 100%;
            height: 240px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .producto .nombre {
            font-size: 16px;
            margin-bottom: 5px;
            color: #111;
        }

        .producto .precio {
            font-size: 15px;
            font-weight: 600;
            color: #c2185b;
            margin-bottom: 10px;
        }

        .producto button {
            background: black;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 30px;
            font-size: 14px;
            cursor: pointer;
            transition: 0.2s;
        }

        .producto button:hover {
            background: #333;
        }

        /* FILTROS SIN CUADRADO CON LÍNEA AL HACER HOVER */
        .filtros {
            text-align: center;
            margin: 30px 0;
        }

        .filtros a {
            margin: 0 12px;
            text-decoration: none;
            color: #111;
            font-size: 15px;
            font-weight: 500;
            position: relative;
            padding-bottom: 3px;
        }

        .filtros a:hover::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background: black;
        }

        .filtros a:hover {
            color: black;
        }

        /* CARRITO */
        #carritoOffCanvas {
            display: none;
            position: fixed;
            top: 0;
            right: 0;
            width: 350px;
            height: 100%;
            background: white;
            border-left: 1px solid #ddd;
            padding: 20px;
            box-shadow: -5px 0 10px rgba(0,0,0,0.1);
            overflow-y: auto;
            z-index: 1000;
        }

        #carritoOffCanvas button {
            margin-top: 10px;
            background: black;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 25px;
            cursor: pointer;
        }

        #carritoOffCanvas button:hover {
            background: #333;
        }
    </style>
</head>
<body>

<!-- HEADER -->
<header class="barra-navegacion">
    <div class="contenedor-logo">
        <img src="{{ asset('imagenes/logo-esmo.png') }}" alt="ESMO" class="logo">
    </div>

    <form method="GET" action="{{ route('cliente.tienda') }}" class="contenedor-busqueda">
        <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Buscar joya..." class="input-buscar">
    </form>

    <div class="contenedor-acciones">
    @if (session('usuario_id'))
        <div style="position: relative;">
            <button class="boton-nav" onclick="toggleMenu()">Hola, {{ session('usuario_nombre') }} ▼</button>
            <div id="menuUsuario" style="display:none; position:absolute; right:0; background:white; border:1px solid #ccc; border-radius: 8px; padding:10px; z-index:999;">
                <a href="{{ route('usuario.pedidos') }}" class="boton-nav" style="display:block; margin-bottom: 8px; color:#111;">Mis pedidos</a>
                <a href="{{ route('usuario.info') }}" class="boton-nav" style="display:block; color:#111;">Mi información</a>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}" style="display:inline;">
            @csrf
            <button type="submit" class="boton-nav">Cerrar sesión</button>
        </form>
    @else
        <a href="{{ route('login') }}" class="boton-nav">Iniciar sesión</a>
        <a href="{{ route('register.show') }}" class="boton-nav">Registrarse</a>
    @endif
        <button type="button" onclick="toggleCarrito()" class="boton-nav">🛒 Carrito (<span id="cantidadCarrito">0</span>)</button>
    </div>
</header>

<!-- FILTROS -->
<div class="filtros">
    <a href="{{ route('cliente.tienda', ['categoria' => 'pulsera']) }}">Pulsera</a>
    <a href="{{ route('cliente.tienda', ['categoria' => 'collar']) }}">Collar</a>
    <a href="{{ route('cliente.tienda', ['categoria' => 'pendiente']) }}">Pendiente</a>
    <a href="{{ route('cliente.tienda') }}">Todos</a>
</div>

<!-- GRID DE PRODUCTOS -->
<div class="grid-productos">
    @foreach ($productos as $producto)
        <div class="producto" data-id="{{ $producto->id }}">
            <a href="{{ route('producto.ver', $producto->id) }}" style="text-decoration: none; color: inherit;">
                @if($producto->imagen)
                    <img src="{{ asset('imagenes/' . $producto->imagen) }}" alt="{{ $producto->nombre }}">
                @endif
                <div class="nombre">{{ $producto->nombre }}</div>
            </a>
            <div class="precio">€{{ number_format($producto->precio, 2, ',', '.') }}</div>
            <button onclick="agregarAlCarrito({{ $producto->id }})">Añadir al carrito</button>
        </div>
    @endforeach
</div>

<!-- CARRITO OFF CANVAS -->
<div id="carritoOffCanvas">
    <h3>Tu carrito</h3>
    <ul id="listaCarrito"></ul>
    <p><strong>Total: €<span id="totalCarrito">0.00</span></strong></p>
    <button onclick="finalizarCompra()">Finalizar compra</button>
    <button onclick="toggleCarrito()">Cerrar</button>
</div>

<!-- SCRIPTS -->
<script>
    let carrito = JSON.parse(localStorage.getItem('carrito')) || [];

    function agregarAlCarrito(id) {
        const productoExistente = carrito.find(p => p.id === id);
        if (productoExistente) {
            productoExistente.cantidad += 1;
        } else {
            carrito.push({ id, cantidad: 1 });
        }
        localStorage.setItem('carrito', JSON.stringify(carrito));
        actualizarVistaCarrito();
        alert("Producto añadido al carrito.");
    }

    function actualizarVistaCarrito() {
        const lista = document.getElementById('listaCarrito');
        const cantidadCarrito = document.getElementById('cantidadCarrito');
        const total = document.getElementById('totalCarrito');

        lista.innerHTML = '';
        let totalPrecio = 0;
        let totalCantidad = 0;

        carrito.forEach(item => {
            const productoDiv = document.querySelector(`.producto[data-id="${item.id}"]`);
            const nombre = productoDiv?.querySelector('.nombre')?.innerText || 'Producto';
            const precioStr = productoDiv?.querySelector('.precio')?.innerText.replace('€', '').replace(',', '.') || '0';
            const precio = parseFloat(precioStr);

            totalPrecio += precio * item.cantidad;
            totalCantidad += item.cantidad;

            lista.innerHTML += `
                <li>
                    ${nombre} x${item.cantidad} (€${(precio * item.cantidad).toFixed(2)})
                    <button onclick="eliminarDelCarrito(${item.id})">🗑️</button>
                </li>`;
        });

        total.textContent = totalPrecio.toFixed(2);
        cantidadCarrito.textContent = totalCantidad;
    }

    function eliminarDelCarrito(id) {
        carrito = carrito.filter(p => p.id !== id);
        localStorage.setItem('carrito', JSON.stringify(carrito));
        actualizarVistaCarrito();
    }

    function toggleCarrito() {
        const carritoDiv = document.getElementById('carritoOffCanvas');
        carritoDiv.style.display = carritoDiv.style.display === 'block' ? 'none' : 'block';
        if (carritoDiv.style.display === 'block') {
            actualizarVistaCarrito();
        }
    }

    function finalizarCompra() {
        if (!carrito.length) return alert('Tu carrito está vacío');

        let total = 0;
        carrito.forEach(p => {
            const productoDiv = document.querySelector(`.producto[data-id="${p.id}"]`);
            const precioStr = productoDiv?.querySelector('.precio')?.innerText.replace('€', '').replace(',', '.');
            const precio = parseFloat(precioStr);
            total += precio * p.cantidad;
        });

        localStorage.setItem('carritoTotal', total.toFixed(2));
        window.location.href = '/confirmar-pedido';
    }

    function toggleMenu() {
        const menu = document.getElementById('menuUsuario');
        menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
    }

    actualizarVistaCarrito();
</script>
<!-- FOOTER -->
<footer style="background: #111; color: white; padding: 40px 20px; text-align: center; margin-top: 60px;">
    <div style="margin-bottom: 20px;">
        <a href="https://instagram.com" target="_blank" style="margin: 0 10px; color: white; text-decoration: none; font-size: 18px;">Instagram</a>
        <a href="https://facebook.com" target="_blank" style="margin: 0 10px; color: white; text-decoration: none; font-size: 18px;">Facebook</a>
        <a href="https://tiktok.com" target="_blank" style="margin: 0 10px; color: white; text-decoration: none; font-size: 18px;">TikTok</a>
    </div>

    <div style="margin-bottom: 15px; font-size: 14px;">
        <a href="#" style="margin: 0 8px; color: #ccc; text-decoration: none;">Aviso legal</a>
        |
        <a href="#" style="margin: 0 8px; color: #ccc; text-decoration: none;">Política de privacidad</a>
        |
        <a href="#" style="margin: 0 8px; color: #ccc; text-decoration: none;">Términos y condiciones</a>
    </div>

    <div style="font-size: 13px; color: #aaa;">
        © {{ date('Y') }} ESMO. Todos los derechos reservados.
    </div>
</footer>
</body>
</html>
