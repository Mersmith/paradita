<?php

namespace Database\Factories;

use App\Models\Producto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Producto>
 */
class ProductoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->word,
            'unidad_medida_id' => 1, // Puedes cambiarlo si necesitas lógica diferente
            'precio_compra' => $this->faker->randomFloat(2, 0.5, 5),
            'precio_venta' => $this->faker->randomFloat(2, 1, 10),
        ];
    }
}
