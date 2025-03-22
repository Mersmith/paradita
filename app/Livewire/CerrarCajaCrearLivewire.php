<?php

namespace App\Livewire;

use App\Models\AperturaCaja;
use App\Models\CierreCaja;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.erp.layout-erp')]
class CerrarCajaCrearLivewire extends Component
{
    public $aperturaCaja;
    public $billete_200 = 0, $billete_100 = 0, $billete_50 = 0, $billete_20 = 0, $billete_10 = 0;
    public $moneda_5 = 0, $moneda_2 = 0, $moneda_1 = 0, $moneda_050 = 0, $moneda_020 = 0, $moneda_010 = 0;
    public $monto_tarjeta = 0, $monto_billetera_digital = 0;
    public $monto_contado = 0, $monto_total = 0;
    public $observaciones;

    public $billetes = [
        ['id' => 200, 'nombre' => 'billete_200', 'valor' => 200],
        ['id' => 100, 'nombre' => 'billete_100', 'valor' => 100],
        ['id' => 50, 'nombre' => 'billete_50', 'valor' => 50],
        ['id' => 20, 'nombre' => 'billete_20', 'valor' => 20],
        ['id' => 10, 'nombre' => 'billete_10', 'valor' => 10],
    ];

    public $monedas = [
        ['id' => 5, 'nombre' => 'moneda_5', 'valor' => 5],
        ['id' => 2, 'nombre' => 'moneda_2', 'valor' => 2],
        ['id' => 1, 'nombre' => 'moneda_1', 'valor' => 1],
        ['id' => 0.50, 'nombre' => 'moneda_050', 'valor' => 0.50],
        ['id' => 0.20, 'nombre' => 'moneda_020', 'valor' => 0.20],
        ['id' => 0.10, 'nombre' => 'moneda_010', 'valor' => 0.10],
    ];

    public function mount($id)
    {
        $this->aperturaCaja = AperturaCaja::findOrFail($id);
    }

    public function calcularMontos()
    {
        // Calcular efectivo contado (sin tarjeta ni billetera digital)
        $this->monto_contado =
            ($this->billete_200 * 200) + ($this->billete_100 * 100) + ($this->billete_50 * 50) +
            ($this->billete_20 * 20) + ($this->billete_10 * 10) +
            ($this->moneda_5 * 5) + ($this->moneda_2 * 2) + ($this->moneda_1 * 1) +
            ($this->moneda_050 * 0.50) + ($this->moneda_020 * 0.20) + ($this->moneda_010 * 0.10);

        // Monto total (incluyendo tarjetas y billeteras)
        $this->monto_total = $this->monto_contado + $this->monto_tarjeta + $this->monto_billetera_digital;
    }

    public function cerrarCaja()
    {
        $this->calcularMontos();
        $montoCalculado = $this->aperturaCaja->monto_inicial; // Modificar si incluye ventas

        CierreCaja::create([
            'apertura_caja_id' => $this->aperturaCaja->id,
            'fecha_cierre' => now(),
            'billete_200' => $this->billete_200,
            'billete_100' => $this->billete_100,
            'billete_50' => $this->billete_50,
            'billete_20' => $this->billete_20,
            'billete_10' => $this->billete_10,
            'moneda_5' => $this->moneda_5,
            'moneda_2' => $this->moneda_2,
            'moneda_1' => $this->moneda_1,
            'moneda_50' => $this->moneda_050,
            'moneda_20' => $this->moneda_020,
            'moneda_10' => $this->moneda_010,
            'monto_tarjeta' => $this->monto_tarjeta,
            'monto_billetera_digital' => $this->monto_billetera_digital,
            'monto_efectivo' => $this->monto_contado,
            'monto_calculado' => $montoCalculado,
            'monto_contado' => $this->monto_total,
            'diferencia' => $this->monto_total - $montoCalculado,
            'observaciones' => $this->observaciones,
        ]);

        $this->aperturaCaja->update([
            'estado' => 'cerrada',
            'hora_cierre' => now()->format('H:i:s'),
            'monto_final' => $this->monto_total,
        ]);

        session()->flash('success', 'La caja ha sido cerrada exitosamente.');
        return redirect()->route('apertura-caja.vista.todas');
    }

    public function updated($propertyName)
    {
        if (in_array($propertyName, [
            'billete_200', 'billete_100', 'billete_50', 'billete_20', 'billete_10',
            'moneda_5', 'moneda_2', 'moneda_1', 'moneda_050', 'moneda_020', 'moneda_010',
            'monto_tarjeta', 'monto_billetera_digital',
        ])) {
            $this->calcularMontos();
        }
    }
    public function render()
    {
        return view('livewire.cerrar-caja-crear-livewire');
    }
}
