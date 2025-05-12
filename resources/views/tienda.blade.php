<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>ESMO | Colección de joyas</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #fffdfd; margin: 0; padding: 0; color: #111; }
        .barra-navegacion { display: flex; justify-content: space-between; align-items: center; padding: 20px 40px; background: #fff; border-bottom: 1px solid #eee; }
        .contenedor-logo .logo { height: 90px; }
        .contenedor-busqueda { flex-grow: 1; margin: 0 40px; }
        .input-buscar { width: 100%; padding: 10px 16px; font-size: 15px; border-radius: 25px; border: 1px solid #ccc; }
        .contenedor-acciones { display: flex; gap: 15px; }
        .boton-nav { text-decoration: none; color: black; font-size: 14px; padding: 8px 14px; border: 1px solid #ccc; border-radius: 25px; transition: 0.2s; background: white; }
        .boton-nav:hover { background: #f0f0f0; }
        .grid-productos { display: grid; grid-template-columns: repeat(4, 1fr); gap: 30px; padding: 40px; max-width: 1400px; margin: auto; }
        .producto { background: #fff; border: 1px solid #eee; border-radius: 12px; text-align: center; padding: 15px; transition: 0.3s; }
        .producto:hover { box-shadow: 0 8px 24px rgba(0,0,0,0.08); transform: translateY(-4px); }
        .producto img { width: 100%; height: 240px; object-fit: cover; border-radius: 8px; margin-bottom: 15px; }
        .producto .nombre { font-size: 16px; margin-bottom: 5px; color: #111; }
        .producto .precio { font-size: 15px; font-weight: 600; color: #c2185b; margin-bottom: 10px; }
        .producto button { background: black; color: white; border: none; padding: 10px 20px; border-radius: 30px; font-size: 14px; cursor: pointer; transition: 0.2s; }
        .producto button:hover { background: #333; }
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
            <span>Hola, {{ session('usuario_nombre') }}</span>
            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit" class="boton-nav" style="background: #eee;">Cerrar sesión</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="boton-nav">Iniciar sesión</a>
            <a href="{{ route('register.show') }}" class="boton-nav">Registrarse</a>
        @endif
        <button type="button" onclick="toggleCarrito()" class="boton-nav">🛒 Carrito (<span id="cantidadCarrito">0</span>)</button>
    </div>
</header>

<!-- BOTONES DE FILTRO -->
<div style="text-align: center; margin-top: 20px;">
    <a href="{{ route('cliente.tienda', ['categoria' => 'pulsera']) }}" class="boton-nav">Pulsera</a>
    <a href="{{ route('cliente.tienda', ['categoria' => 'collar']) }}" class="boton-nav">Collar</a>
    <a href="{{ route('cliente.tienda', ['categoria' => 'pendiente']) }}" class="boton-nav">Pendiente</a>
    <a href="{{ route('cliente.tienda') }}" class="boton-nav" style="background:#eee;">Todos</a>
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
<div id="carritoOffCanvas" style="display: none; position: fixed; top: 0; right: 0; width: 350px; height: 100%; background: white; border-left: 1px solid #ddd; padding: 20px; box-shadow: -5px 0 10px rgba(0,0,0,0.1); overflow-y: auto; z-index: 1000;">
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
        if (carritoDiv.style.display === 'block') {
            carritoDiv.style.display = 'none';
        } else {
            carritoDiv.style.display = 'block';
            actualizarVistaCarrito();
        }
    }

    actualizarVistaCarrito();
</script>
<script>
function finalizarCompra() {
    if (!carrito.length) return alert('Tu carrito está vacío');

    const total = parseFloat(document.getElementById('totalCarrito').textContent);
    const productos = carrito.map(p => ({ id: p.id, cantidad: p.cantidad }));
    const usuarioId = {{ session('usuario_id') ? 'true' : 'false' }};

    let correo = null;
    if (!usuarioId) {
        correo = prompt("Introduce tu correo para recibir el pedido:");
        if (!correo) return alert("Debes introducir un correo válido.");
    }

    fetch('/realizar-pedido', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ productos, total, correo })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert("Pedido realizado con éxito.");
            localStorage.removeItem('carrito');
            location.reload();
        } else {
            alert("Error al realizar el pedido.");
        }
    })
    .catch(() => alert("Error de servidor."));
}
</script>


</body>
</html>
