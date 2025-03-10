<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UnidadMedida;
class UnidadMedidaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $unidades = [
            ['nombre' => 'Kilogramo'],
            ['nombre' => 'Unidad'],
        ];

        UnidadMedida::insert($unidades);
    }
}
