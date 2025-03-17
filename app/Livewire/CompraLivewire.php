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

    protected $paginate = 20;

    public function updatingBuscarCompra()
    {
        $this->resetPage();
    }

    public function updatingPaginacion()
    {
        $this->resetPage();
    }

    public function render()
    {
        $compras = Compra::orderBy('created_at', 'desc')
        ->paginate(20);

        return view('livewire.compra-livewire', [
            'compras' => $compras,
        ]);
    }
}
