<!DOCTYPE html>
<html>
<head>
    <title>Pago con Stripe</title>
    <style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background: #fffdfd;
        margin: 0;
        padding: 0;
        color: #111;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    form {
        background: white;
        padding: 40px 30px;
        border: 1px solid #eee;
        border-radius: 12px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.06);
        max-width: 420px;
        width: 100%;
    }

    #card-element {
        padding: 14px;
        border: 1px solid #ccc;
        border-radius: 8px;
        margin-bottom: 20px;
        background: #f9f9f9;
    }

    button[type="submit"] {
        background: black;
        color: white;
        padding: 12px 20px;
        font-size: 15px;
        border: none;
        border-radius: 30px;
        cursor: pointer;
        width: 100%;
        transition: background 0.3s ease;
    }

    button[type="submit"]:hover {
        background: #333;
    }

    p {
        text-align: center;
        margin-bottom: 20px;
        font-size: 14px;
    }

    p[style*="color:green"] {
        color: #2e7d32 !important;
        background: #e8f5e9;
        padding: 10px;
        border-radius: 8px;
    }

    p[style*="color:red"] {
        color: #c62828 !important;
        background: #ffebee;
        padding: 10px;
        border-radius: 8px;
    }
</style>
    <script src="https://js.stripe.com/v3/"></script>
</head>
<body>
    @if(session('success'))
        <p style="color:green;">{{ session('success') }}</p>
    @endif

    @if(session('error'))
        <p style="color:red;">{{ session('error') }}</p>
    @endif

    <form action="{{ route('pago.procesar') }}" method="POST" id="form-pago">
        @csrf
        <input type="hidden" name="productos" id="productos">
        <input type="hidden" name="total" id="total">
        @if (!session('usuario_id'))
            <input type="hidden" name="correo" value="{{ session('datos_pedido.correo') }}">
        @endif
        <div id="card-element"></div>
        <button type="submit">Pagar</button>
    </form>

    <script>
        const stripe = Stripe('{{ env('STRIPE_KEY') }}');
        const elements = stripe.elements();
        const card = elements.create('card');
        card.mount('#card-element');

        // Recuperar productos y total desde localStorage
        const carrito = JSON.parse(localStorage.getItem('carrito') || '[]');
        const total = parseFloat(localStorage.getItem('carritoTotal') || '0');

        const productos = carrito.map(p => ({ id: p.id, cantidad: p.cantidad }));

        document.getElementById('productos').value = JSON.stringify(productos);
        document.getElementById('total').value = total.toFixed(2);

        const form = document.getElementById('form-pago');
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const { token, error } = await stripe.createToken(card);
            if (error) {
                alert(error.message);
                return;
            }

            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'stripeToken';
            input.value = token.id;
            form.appendChild(input);

            form.submit();
        });
    </script>
</body>
</html>
