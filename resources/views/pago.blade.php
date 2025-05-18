<!DOCTYPE html>
<html>
<head>
    <title>Pago con Stripe</title>
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
