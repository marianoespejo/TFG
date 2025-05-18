<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usuario_id')->nullable();
            $table->string('correo');         // Para usuarios no registrados
            $table->string('direccion')->nullable(); // ✅      // Dirección de envío
            $table->json('productos');                    // Lista de productos
            $table->decimal('total', 8, 2);               // Precio total
            $table->string('estado')->default('pendiente'); // Estado del pedido
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
