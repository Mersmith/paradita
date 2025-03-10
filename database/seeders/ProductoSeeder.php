<?php

namespace Database\Seeders;

use App\Models\Compra;
use App\Models\DetalleCompra;
use App\Models\DetalleVenta;
use App\Models\HistorialPrecio;
use App\Models\HistorialPrecioCompra;
use App\Models\HistorialPrecioVenta;
use App\Models\Inventario;
use App\Models\Producto;
use App\Models\Venta;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productos = [
            ['nombre' => 'Papa', 'unidad_medida_id' => 1, 'precio_compra' => 0.60, 'precio_venta' => 2.00],
            ['nombre' => 'Cebolla', 'unidad_medida_id' => 1, 'precio_compra' => 0.50, 'precio_venta' => 1.50],
            ['nombre' => 'Brócoli', 'unidad_medida_id' => 2, 'precio_compra' => 1.00, 'precio_venta' => 3.00],
            ['nombre' => 'Zapallo', 'unidad_medida_id' => 1, 'precio_compra' => 0.80, 'precio_venta' => 1.50],
        ];
    
        foreach ($productos as $data) {
            $producto = Producto::create($data);
            Inventario::create(['producto_id' => $producto->id, 'stock' => 0]);
        }
    }
}
