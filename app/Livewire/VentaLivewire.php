<?php

namespace App\Livewire;

use App\Models\Venta;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.erp.layout-erp')]
class VentaLivewire extends Component
{

    use WithPagination;

    public $buscarVenta;
    public $fechaInicio;
    public $fechaFin;

    protected $paginate = 20;

    public function updatingBuscarVenta()
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
        $query = Venta::orderBy('fecha', 'desc');

        // Filtrar por texto (ID o cualquier campo relevante)
        if ($this->buscarVenta) {
            $query->where('id', 'like', '%' . $this->buscarVenta . '%');
        }

        // Filtrar por rango de fecha
        if ($this->fechaInicio && $this->fechaFin) {
            $query->whereBetween('fecha', [$this->fechaInicio . " 00:00:00", $this->fechaFin . " 23:59:59"]);
        }

        $ventas = $query->paginate(20);

        return view('livewire.venta-livewire', [
            'ventas' => $ventas,
        ]);
    }
}
