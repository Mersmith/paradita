<?php

namespace App\Livewire;

use App\Models\AperturaCaja;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.erp.layout-erp')]
class AperturaCajaLivewire extends Component
{
    
    use WithPagination;

    public $buscarCaja;
    public $fechaInicio;
    public $fechaFin;

    protected $paginate = 20;

    public function updatingBuscarCaja()
    {
        $this->resetPage();
    }

    public function updatingFechaInicio()
    {
        $this->resetPage();
    }

    public function updatingFechaFin()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = AperturaCaja::orderBy('fecha', 'desc');

        // Filtrar por ID de caja
        if ($this->buscarCaja) {
            $query->where('id', 'like', '%' . $this->buscarCaja . '%');
        }

        // Filtrar por rango de fechas
        if ($this->fechaInicio && $this->fechaFin) {
            $query->whereBetween('fecha', [$this->fechaInicio, $this->fechaFin]);
        }

        $cajas = $query->paginate(20);

        return view('livewire.apertura-caja-livewire', [
            'cajas' => $cajas,
        ]);
    }
}
