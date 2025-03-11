<?php

namespace App\Livewire;

use App\Models\Producto;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.erp.layout-erp')]
class ProductoLivewire extends Component
{
    use WithPagination;
    public $buscarProducto;

    protected $paginate = 20;

    public function updatingBuscarProducto()
    {
        $this->resetPage();
    }

    public function updatingPaginacion()
    {
        $this->resetPage();
    }
    public function render()
    {
        $productos = Producto::with('unidadMedida')
            ->where('nombre', 'like', '%' . $this->buscarProducto . '%')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('livewire.producto-livewire', [
            'productos' => $productos,
        ]);
    }
}
