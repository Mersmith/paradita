<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use App\Models\UnidadMedida;
#[Layout('layouts.erp.layout-erp')]
class UnidadMedidaLivewire extends Component
{

    use WithPagination;

    public $nombre;
    public $unidad_id;
    public $modo_edicion = false;

    protected $rules = [
        'nombre' => 'required|string|unique:unidad_medidas,nombre',
    ];

   

    public function guardarUnidad() {
        $this->validate();
        UnidadMedida::create(['nombre' => $this->nombre]);
        $this->reset('nombre');
        session()->flash('message', 'Unidad de medida creada correctamente.');
    }

    public function editarUnidad($id) {
        $unidad = UnidadMedida::findOrFail($id);
        $this->unidad_id = $unidad->id;
        $this->nombre = $unidad->nombre;
        $this->modo_edicion = true;
    }

    public function actualizarUnidad() {
        $this->validate();
        $unidad = UnidadMedida::findOrFail($this->unidad_id);
        $unidad->update(['nombre' => $this->nombre]);
        $this->reset(['nombre', 'unidad_id', 'modo_edicion']);
        session()->flash('message', 'Unidad de medida actualizada correctamente.');
    }

    public function eliminarUnidad($id) {
        UnidadMedida::findOrFail($id)->delete();
        session()->flash('message', 'Unidad de medida eliminada correctamente.');
    }

    public function render() {
        return view('livewire.unidad-medida-livewire', [
            'unidades' => UnidadMedida::paginate(5),
        ]);
    }
}
