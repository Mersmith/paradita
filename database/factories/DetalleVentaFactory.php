<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\DetalleVenta;
use App\Models\Venta;
use App\Models\Producto;
use App\Models\UnidadMedida;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DetalleVenta>
 */
class DetalleVentaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $cantidad = $this->faker->randomFloat(2, 1, 50);
        $precio_unitario = $this->faker->randomFloat(2, 5, 200);
        return [
            'venta_id' => Venta::factory(),
            'producto_id' => Producto::factory(),
            'unidad_medida_id' => UnidadMedida::factory(),
            'cantidad' => $cantidad,
            'cantidad_convertida' => $cantidad,
            'precio_unitario' => $precio_unitario,
        ];
    }
}
