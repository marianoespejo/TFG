<?php

use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\PagoController;

// Tienda
Route::get('/', [ClienteController::class, 'tienda'])->name('cliente.tienda');

// Producto individual
Route::get('/producto/{producto}', [ClienteController::class, 'mostrar'])->name('producto.ver');

// Login y Logout
Route::get('/login', [ClienteController::class, 'loginForm'])->name('login');
Route::post('/login', [ClienteController::class, 'login']);
Route::post('/logout', [ClienteController::class, 'logout'])->name('logout');

// Registro
Route::get('/register', [RegisterController::class, 'show'])->name('register.show');
Route::post('/register', [RegisterController::class, 'register'])->name('register.store');

// Confirmación y dirección del pedido
Route::get('/confirmar-pedido', [PedidoController::class, 'confirmarVista'])->name('pedido.confirmar');
Route::post('/confirmar-pedido', [PedidoController::class, 'guardarDatosYRedirigir'])->name('pedido.guardar');

// Checkout (no necesaria si ya usas confirmar)
Route::get('/checkout', [PedidoController::class, 'checkout'])->name('checkout');

// Pedido (solo si lo usas sin Stripe)
Route::post('/realizar-pedido', [PedidoController::class, 'realizar'])->name('pedido.realizar');

// Pago con Stripe
Route::get('/pago', [PagoController::class, 'form'])->name('pago.formulario'); // ✅ nombre corregido
Route::post('/procesar-pago', [PagoController::class, 'procesar'])->name('pago.procesar');

// Admin - Gestión de productos
Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
Route::get('/admin/crear', [AdminController::class, 'create'])->name('admin.create');
Route::post('/admin', [AdminController::class, 'store'])->name('admin.store');
Route::get('/admin/{producto}/editar', [AdminController::class, 'edit'])->name('admin.edit');
Route::put('/admin/{producto}', [AdminController::class, 'update'])->name('admin.update');
Route::delete('/admin/{producto}', [AdminController::class, 'destroy'])->name('admin.destroy');

// Admin - Ver pedidos
Route::get('/admin/pedidos', [AdminController::class, 'verPedidos'])->name('admin.pedidos');

// Cliente - Pedidos e información
Route::get('/mis-pedidos', [ClienteController::class, 'misPedidos'])->name('usuario.pedidos'); // cambia aquí
Route::get('/mi-informacion', [ClienteController::class, 'miInformacion'])->name('usuario.info'); // 👈 nombre uniforme
Route::put('/mi-informacion', [ClienteController::class, 'actualizarInformacion'])->name('usuario.actualizar');