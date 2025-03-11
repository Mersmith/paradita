<?php

namespace App\Livewire;

use App\Models\Inventario;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.erp.layout-erp')]
class InventarioLivewire extends Component
{
    use WithPagination;

    public $buscarProducto = '';

    protected $listeners = ['actualizarInventario' => '$refresh'];

    public function updatingBuscarProducto()
    {
        $this->resetPage();
    }

    public function render()
    {
        $inventarios = Inventario::with('producto')
            ->whereHas('producto', function ($query) {
                $query->where('nombre', 'like', '%' . $this->buscarProducto . '%');
            })
            ->orderBy('producto_id', 'asc')
            ->paginate(20);

        return view('livewire.inventario-livewire', compact('inventarios'));
    }
}
