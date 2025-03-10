<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\DetalleCompra;
use App\Models\Compra;
use App\Models\Producto;
use App\Models\UnidadMedida;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DetalleCompra>
 */
class DetalleCompraFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $cantidad = $this->faker->randomFloat(2, 1, 50);
        $precio_unitario = $this->faker->randomFloat(2, 1, 100);
        return [
            'compra_id' => Compra::factory(),
            'producto_id' => Producto::factory(),
            'unidad_medida_id' => UnidadMedida::factory(),
            'cantidad' => $cantidad,
            'cantidad_convertida' => $cantidad, // Suponiendo que la conversión es 1:1
            'precio_total' => $cantidad * $precio_unitario,
            'precio_unitario' => $precio_unitario,
        ];
    }
}
