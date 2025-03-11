<?php

namespace App\Livewire;

use App\Models\UnidadMedida;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\Attributes\On;

#[Layout('layouts.erp.layout-erp')]
class UnidadMedidaEditarLivewire extends Component
{
    public $unidad;
    public $nombre;

    protected $rules = [
        'nombre' => 'required|string|max:255|unique:unidad_medidas,nombre',
    ];

    protected $validationAttributes = [
        'nombre' => 'nombre de la unidad',
    ];

    protected $messages = [
        'nombre.required' => 'El :attribute es obligatorio.',
        'nombre.unique' => 'El :attribute ya está registrado. Debe ser único.',
    ];

    public function mount($id)
    {
        $this->unidad = UnidadMedida::findOrFail($id);

        $this->nombre = $this->unidad->nombre;
    }

    public function guardar()
    {
        $this->validate([
            'nombre' => 'required|string|max:255|unique:unidad_medidas,nombre,' . $this->unidad->id,
        ]);

        $this->unidad->update([
            'nombre' => $this->nombre,
        ]);

        return redirect()->route('unidad-medida.vista.todas');
    }

    #[On('eliminarUnidadOn')]
    public function eliminarUnidadOn($id)
    {
        $unidad = UnidadMedida::where('id', $id)->first();
        $unidad->delete();

        return redirect()->route('unidad-medida.vista.todas');
    }

    public function render()
    {
        return view('livewire.unidad-medida-editar-livewire');
    }
}
