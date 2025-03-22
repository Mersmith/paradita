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
        Schema::create('cierre_cajas', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('apertura_caja_id');
            $table->foreign('apertura_caja_id')->references('id')->on('apertura_cajas')->onDelete('cascade');

            $table->dateTime('fecha_cierre');

            // Cantidad de cada billete
            $table->integer('billete_200')->default(0);
            $table->integer('billete_100')->default(0);
            $table->integer('billete_50')->default(0);
            $table->integer('billete_20')->default(0);
            $table->integer('billete_10')->default(0);

            // Cantidad de cada moneda
            $table->integer('moneda_5')->default(0);
            $table->integer('moneda_2')->default(0);
            $table->integer('moneda_1')->default(0);
            $table->integer('moneda_50')->default(0);
            $table->integer('moneda_20')->default(0);
            $table->integer('moneda_10')->default(0);

            // Montos de otros métodos de pago
            $table->decimal('monto_tarjeta', 10, 2)->default(0);
            $table->decimal('monto_billetera_digital', 10, 2)->default(0);

            // Monto total en efectivo (billetes + monedas)
            $table->decimal('monto_efectivo', 10, 2)->default(0);

            // Totales
            $table->decimal('monto_calculado', 10, 2); // Monto esperado (ventas)
            $table->decimal('monto_contado', 10, 2); // Monto contado (físico)
            $table->decimal('diferencia', 10, 2); // Diferencia entre esperado y contado

            $table->text('observaciones')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cierre_cajas');
    }
};
