<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Compra;

#[Layout('layouts.erp.layout-erp')]
class CompraDetalleLivewire extends Component
{
    public $compra;

    public $detalles;


    public function mount($id)
    {
        $this->compra = Compra::find($id);

        if (!$this->compra) {
            abort(404, 'compra no encontrado');
        }

        $this->detalles = $this->compra->detalleCompras;
    }

    public function render()
    {
        return view('livewire.compra-detalle-livewire');
    }
}
