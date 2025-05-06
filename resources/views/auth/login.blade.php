<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar sesión | ESMA</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f7f4f2;
            margin: 0;
            padding: 40px;
            color: #333;
        }
        h1 {
            font-size: 26px;
            color: #c2185b;
            margin-bottom: 30px;
            text-align: center;
        }
        form {
            background-color: white;
            padding: 30px;
            border-radius: 12px;
            max-width: 400px;
            margin: auto;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }
        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 18px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 15px;
        }
        button {
            width: 100%;
            background-color: black;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 25px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background-color: #333;
        }
        .volver {
            display: block;
            margin: 20px auto;
            text-align: center;
            text-decoration: none;
            color: #555;
        }
    </style>
</head>
<body>

    <h1>Iniciar Sesión</h1>

    <form action="{{ route('login') }}" method="POST">
        @csrf

        <input type="email" name="email" placeholder="Correo electrónico" required>
        <input type="password" name="password" placeholder="Contraseña" required>

        <button type="submit">Entrar</button>
    </form>

    <a href="{{ route('cliente.tienda') }}" class="volver">← Volver a la tienda</a>

</body>
</html>
