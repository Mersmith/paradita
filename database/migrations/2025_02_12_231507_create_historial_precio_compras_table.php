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
        Schema::create('historial_precio_compras', function (Blueprint $table) {
            $table->id();

            $table->foreignId('producto_id')->constrained()->onDelete('cascade');
            $table->decimal('precio_unitario', 10, 2); // Precio por kg o unidad base
            $table->decimal('cantidad', 10, 2); // Cuánto se compró con este precio
            $table->date('fecha'); // Fecha de compra

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historial_precio_compras');
    }
};
