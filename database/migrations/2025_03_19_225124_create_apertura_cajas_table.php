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
        Schema::create('apertura_cajas', function (Blueprint $table) {
            $table->id();

            $table->date('fecha')->unique(); // Solo una apertura por día
            $table->time('hora_apertura');
            $table->decimal('monto_inicial', 10, 2);
            $table->enum('estado', ['abierta', 'cerrada'])->default('abierta');
            $table->time('hora_cierre')->nullable(); // Puede ser NULL si la caja aún no se cierra
            $table->decimal('monto_final', 10, 2)->nullable(); // Nuevo campo para guardar el total al cierre

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apertura_cajas');
    }
};
