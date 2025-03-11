<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\UnidadMedida;

#[Layout('layouts.erp.layout-erp')]
class UnidadMedidaLivewire extends Component
{
    use WithPagination;
    public $buscarUnidad;

    protected $paginate = 20;

    public function updatingBuscarUnidad()
    {
        $this->resetPage();
    }

    public function updatingPaginacion()
    {
        $this->resetPage();
    }

    public function render()
    {
        $unidades = UnidadMedida::where('nombre', 'like', '%' . $this->buscarUnidad . '%')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('livewire.unidad-medida-livewire', [
            'unidades' => $unidades,
        ]);
    }
}
