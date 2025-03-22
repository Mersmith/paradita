<?php

namespace App\Livewire;

use App\Models\AperturaCaja;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.erp.layout-erp')]
class AperturaCajaCrearLivewire extends Component
{
    public $monto_inicial;
    public $monto_final;
    public $estado;
    public $hora_apertura;
    public $hora_cierre;
    public $aperturaHoy;
    public $editando_monto_inicial = false;
    public $editando_monto_final = false;

    public function mount()
    {
        $this->aperturaHoy = AperturaCaja::whereDate('fecha', Carbon::today())->first();

        if ($this->aperturaHoy) {
            $this->monto_inicial = $this->aperturaHoy->monto_inicial;
            $this->monto_final = $this->aperturaHoy->monto_final;
            $this->estado = $this->aperturaHoy->estado;
            $this->hora_apertura = $this->aperturaHoy->hora_apertura;
            $this->hora_cierre = $this->aperturaHoy->hora_cierre;
        }
    }

    public function abrirCaja()
    {
        if ($this->aperturaHoy) {
            $this->dispatch('alert', 'Ya existe una apertura para hoy.');
            return;
        }

        $this->aperturaHoy = AperturaCaja::create([
            'fecha' => Carbon::today(),
            'hora_apertura' => Carbon::now()->format('H:i:s'),
            'monto_inicial' => $this->monto_inicial,
            'estado' => 'abierta',
        ]);

        $this->mount();
        $this->dispatch('alert', 'Caja abierta con éxito.');
    }

    public function cerrarCaja()
    {
        if (!$this->aperturaHoy) {
            $this->dispatch('alert', 'No hay caja abierta para cerrar.');
            return;
        }

        $this->aperturaHoy->update([
            'hora_cierre' => Carbon::now()->format('H:i:s'),
            'monto_final' => $this->monto_final,
            'estado' => 'cerrada',
        ]);

        $this->mount();
        $this->dispatch('alert', 'Caja cerrada con éxito.');
    }

    public function editarMontoInicial()
    {
        $this->editando_monto_inicial = true;
    }

    public function guardarMontoInicial()
    {
        if ($this->aperturaHoy && $this->aperturaHoy->estado === 'abierta') {
            $this->aperturaHoy->update(['monto_inicial' => $this->monto_inicial]);
            $this->dispatch('alert', 'Monto inicial actualizado.');
        }
        $this->editando_monto_inicial = false;
    }

    public function editarMontoFinal()
    {
        $this->editando_monto_final = true;
    }

    public function guardarMontoFinal()
    {
        if ($this->aperturaHoy && $this->aperturaHoy->estado === 'abierta') {
            $this->aperturaHoy->update(['monto_final' => $this->monto_final]);
            $this->dispatch('alert', 'Monto final actualizado.');
        }
        $this->editando_monto_final = false;
    }

    public function render()
    {
        return view('livewire.apertura-caja-crear-livewire');
    }
}
