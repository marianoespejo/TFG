<!DOCTYPE html>
<html>
<head>
    <title>Confirmar pedido</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 40px; background: #f9f9f9; color: #333; }
        form { background: white; padding: 30px; border-radius: 12px; max-width: 500px; margin: auto; box-shadow: 0 0 12px rgba(0,0,0,0.05); }
        label { display: block; margin-top: 20px; font-weight: bold; }
        input, textarea { width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ccc; border-radius: 6px; }
        button { margin-top: 30px; padding: 12px 24px; background: black; color: white; border: none; border-radius: 30px; cursor: pointer; }
        button:hover { background: #333; }
    </style>
</head>
<body>

<h2>Datos de envío</h2>

<form method="POST" action="{{ route('pedido.guardar') }}">
    @csrf

    @if (!session('usuario_id'))
        <label>Correo electrónico:</label>
        <input type="email" name="correo" required>
    @else
        @if(isset($usuario) && $usuario->direccion)
            <p>¿Quieres cambiar tu dirección de envío?</p>
            <label>Dirección de envío:</label>
            <input type="text" name="direccion" value="{{ $usuario->direccion }}" required>
        @else
            <p>Establece tu dirección de envío:</p>
            <label>Dirección de envío:</label>
            <input type="text" name="direccion" required>
        @endif
    @endif

    @if (!session('usuario_id'))
        <label>Dirección de envío:</label>
        <input type="text" name="direccion" required>
    @endif

    <button type="submit">Ir a pagar</button>
</form>

</body>
</html>
