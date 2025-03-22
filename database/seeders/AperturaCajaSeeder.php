<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AperturaCaja;
use Carbon\Carbon;

class AperturaCajaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 20; $i >= 1; $i--) {
            $fecha = Carbon::today()->subDays($i); // Genera desde hace 20 días hasta ayer

            AperturaCaja::create([
                'fecha' => $fecha,
                'hora_apertura' => $fecha->copy()->setTime(rand(8, 10), rand(0, 59), 0), // Hora entre 8:00 y 10:59
                'monto_inicial' => rand(50, 200), // Monto inicial aleatorio
                'estado' => 'cerrada',
                'hora_cierre' => $fecha->copy()->setTime(rand(18, 22), rand(0, 59), 0), // Hora de cierre entre 18:00 y 22:59
                'monto_final' => rand(500, 2000), // Monto final aleatorio
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
