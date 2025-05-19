<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrarse | ESMO</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f7f4f2; margin: 0; padding: 40px; color: #333; }
        form { background: white; padding: 30px; max-width: 400px; margin: auto; border-radius: 12px; box-shadow: 0 0 10px rgba(0,0,0,0.05); }
        h1 { text-align: center; margin-bottom: 30px; color: #c2185b; }
        label { display: block; margin-top: 20px; font-weight: 500; }
        input[type="text"], input[type="email"], input[type="password"] { width: 100%; padding: 12px; border-radius: 6px; border: 1px solid #ccc; font-size: 15px; margin-top: 5px; }
        button { margin-top: 30px; background: black; color: white; padding: 12px; width: 100%; border: none; border-radius: 25px; font-size: 15px; cursor: pointer; }
        button:hover { background: #333; }
    </style>
</head>
<body>

<form method="POST" action="{{ route('register.store') }}">
    @csrf

    <label for="nombre">Nombre</label>
    <input type="text" name="nombre" required>

    <label for="email">Correo electrónico</label>
    <input type="email" name="email" required>

    <label for="password">Contraseña</label>
    <input type="password" name="password" required>

    <button type="submit">Registrarse</button>
</form>


</body>
</html>
