<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Producto;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\HistorialPrecioCompra>
 */
class HistorialPrecioCompraFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'producto_id' => Producto::factory(),
            'precio_unitario' => $this->faker->randomFloat(2, 1, 100),
            'cantidad' => $this->faker->randomFloat(2, 1, 50),
            'fecha' => $this->faker->date(),
        ];
    }
}
