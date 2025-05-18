<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Información</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; padding: 40px; background: #f7f4f2; color: #333; }
        h1 { font-size: 24px; margin-bottom: 30px; }
        form { background: white; padding: 30px; border-radius: 12px; max-width: 500px; margin: auto; box-shadow: 0 0 12px rgba(0,0,0,0.05); }
        label { display: block; margin-top: 20px; font-weight: 500; }
        input { width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #ccc; margin-top: 5px; }
        button { margin-top: 30px; padding: 12px 24px; background: black; color: white; border: none; border-radius: 30px; cursor: pointer; }
        button:hover { background: #333; }
    </style>
</head>
<body>

    <h1>Mi Información</h1>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <form method="POST" action="{{ route('usuario.actualizar') }}">
        @csrf
        @method('PUT')

        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" value="{{ $usuario->nombre }}" required>

        <label for="email">Correo electrónico</label>
        <input type="email" name="email" value="{{ $usuario->email }}" required>

        <label for="direccion">Dirección de envío</label>
        <input type="text" name="direccion" value="{{ $usuario->direccion }}" required>

        <label for="password">Nueva contraseña</label>
        <input type="password" name="password" placeholder="Dejar vacío si no deseas cambiarla">

        <button type="submit">Guardar cambios</button>
    </form>

</body>
</html>
