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
        Schema::create('historial_precio_ventas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('producto_id')->constrained()->onDelete('cascade');
            $table->decimal('precio_venta', 10, 2); // Precio de venta por unidad base
            $table->date('fecha'); // Fecha en la que se cambió el precio

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historial_precio_ventas');
    }
};
