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
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();

            $table->date('fecha');
            // Estado de la venta (proceso interno del negocio)
            $table->enum('estado_venta', [
                'borrador',
                'pendiente_pago',
                'pagado',
                'en_preparacion',
                'enviado',
                'entregado',
                'cancelado',
                'devuelto',
                'eliminado',
            ])->default('borrador');

            // Estado en la SUNAT (validación de comprobante electrónico)
            $table->enum('estado_sunat', [
                'pendiente', // No se ha enviado aún
                'enviado', // Enviado a SUNAT, esperando respuesta
                'aceptado', // Validado por SUNAT
                'observado', // Hay errores, se debe corregir
                'rechazado', // SUNAT rechazó el comprobante
                'anulado', // Se envió nota de crédito para anulación
            ])->default('pendiente');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};
