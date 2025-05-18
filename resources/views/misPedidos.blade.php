<!DOCTYPE html>
<html>
<head><title>Mis pedidos</title></head>
<body>
    <h2>Mis pedidos</h2>
    @foreach ($pedidos as $pedido)
        <div style="border:1px solid #ccc; padding:10px; margin-bottom:15px;">
            <strong>ID Pedido:</strong> {{ $pedido->id }} <br>
            <strong>Total:</strong> €{{ number_format($pedido->total, 2, ',', '.') }} <br>
            <strong>Estado:</strong> {{ ucfirst($pedido->estado) }} <br>
            <strong>Fecha:</strong> {{ $pedido->created_at->format('d/m/Y') }}
        </div>
    @endforeach
</body>
</html>
