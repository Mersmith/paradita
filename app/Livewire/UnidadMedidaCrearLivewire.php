<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use App\Models\UnidadMedida;

#[Layout('layouts.erp.layout-erp')]
class UnidadMedidaCrearLivewire extends Component
{
    public $nombre;
    
    protected $rules = [
        'nombre' => 'required|string|max:255|unique:unidad_medidas,nombre',
    ];
    
    protected $validationAttributes = [
        'nombre' => 'nombre de la medida',
    ];
    
    protected $messages = [
        'nombre.required' => 'El :attribute es obligatorio.',
        'nombre.unique' => 'El :attribute ya está registrado. Debe ser único.',
    ];
   
    public function crear()
    {
        $this->reset(['nombre']);
    }

    public function guardar()
    {
        $this->validate();

        $medida = UnidadMedida::create([
            'nombre' => $this->nombre,
        ]);

        $this->dispatch('alertaLivewire', "Creado");

        $this->crear();
    }

    public function render()
    {
        return view('livewire.unidad-medida-crear-livewire');
    }
}
