<?php

use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\AdminController;

// Tienda
Route::get('/', [ClienteController::class, 'tienda'])->name('cliente.tienda');

// Admin
Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
Route::get('/admin/crear', [AdminController::class, 'create'])->name('admin.create');
Route::post('/admin', [AdminController::class, 'store'])->name('admin.store');
Route::get('/admin/{producto}/editar', [AdminController::class, 'edit'])->name('admin.edit');
Route::put('/admin/{producto}', [AdminController::class, 'update'])->name('admin.update');
Route::delete('/admin/{producto}', [AdminController::class, 'destroy'])->name('admin.destroy');

// Producto individual
Route::get('/producto/{producto}', [ClienteController::class, 'mostrar'])->name('producto.ver');

// Login y Logout
Route::get('/login', [ClienteController::class, 'loginForm'])->name('login');
Route::post('/login', [ClienteController::class, 'login']);
Route::post('/logout', [ClienteController::class, 'logout'])->name('logout');

// Registro - CAMBIADO
Route::get('/register', [RegisterController::class, 'show'])->name('register.show'); // 👈
Route::post('/register', [RegisterController::class, 'register'])->name('register.store'); // 👈

