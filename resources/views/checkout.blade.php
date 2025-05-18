<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Finalizar Pedido | ESMA</title>
    <style>
        body { font-family: sans-serif; padding: 40px; background: #fdf9f8; }
        .contenedor { max-width: 500px; margin: auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 0 10px rgba(0,0,0,0.05); }
        h2 { margin-bottom: 25px; }
        label { display: block; margin-top: 15px; font-weight: bold; }
        input[type="text"], input[type="email"] { width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ccc; border-radius: 6px; }
        .boton { margin-top: 30px; background: black; color: white; padding: 12px 24px; border: none; border-radius: 30px; cursor: pointer; width: 100%; }
        .boton:hover { background: #333; }
        .info { margin-top: 20px; color: #444; }
        a { color: #c2185b; }
    </style>
</head>
<body>

<div class="contenedor">
    <h2>Resumen del Pedido</h2>

    @if(session('usuario_id'))
        <p class="info">Enviaremos tu pedido a tu dirección registrada.</p>
        <p class="info"><strong>Dirección:</strong> {{ $usuario->direccion ?? 'No especificada' }}</p>
        <a href="#">¿Deseas cambiar tu dirección?</a>
    @else
        <form method="POST" action="{{ route('pago.form') }}">
            @csrf
            <label for="correo">Correo electrónico</label>
            <input type="email" name="correo" required>

            <label for="direccion">Dirección de envío</label>
            <input type="text" name="direccion" required>

            <button type="submit" class="boton">Continuar al pago</button>
        </form>
    @endif
</div>

</body>
</html>
