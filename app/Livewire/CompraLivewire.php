<?php

namespace App\Livewire;

use App\Models\Compra;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.erp.layout-erp')]
class CompraLivewire extends Component
{
    use WithPagination;

    public $buscarCompra;
    public $fechaInicio;
    public $fechaFin;

    protected $paginate = 20;

    public function updatingBuscarCompra()
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
        $query = Compra::orderBy('fecha', 'desc');

        // Filtrar por texto (ID o cualquier campo relevante)
        if ($this->buscarCompra) {
            $query->where('id', 'like', '%' . $this->buscarCompra . '%');
        }

        // Filtrar por rango de fecha
        if ($this->fechaInicio && $this->fechaFin) {
            $query->whereBetween('fecha', [$this->fechaInicio . " 00:00:00", $this->fechaFin . " 23:59:59"]);
        }

        $compras = $query->paginate(20);

        return view('livewire.compra-livewire', [
            'compras' => $compras,
        ]);
    }
}
