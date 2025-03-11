<?php

namespace App\Livewire;

use App\Models\Inventario;
use App\Models\Producto;
use App\Models\UnidadMedida;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.erp.layout-erp')]
class ProductoCrearLivewire extends Component
{
    public $nombre, $unidad_medida_id = "", $precio_compra, $precio_venta;
    public $unidades = [];

    protected $rules = [
        'nombre' => 'required|string|max:255|unique:productos,nombre',
        'unidad_medida_id' => 'required|exists:unidad_medidas,id',
        'precio_compra' => 'required|numeric|min:0',
        'precio_venta' => 'required|numeric|min:0',
    ];
    
    protected $validationAttributes = [
        'nombre' => 'nombre del producto',
        'unidad_medida_id' => 'unidad de medida',
        'precio_compra' => 'precio de compra',
        'precio_venta' => 'precio de venta',
    ];
    
    protected $messages = [
        'nombre.required' => 'El :attribute es obligatorio.',
        'nombre.unique' => 'El :attribute ya está registrado. Debe ser único.',
        'unidad_medida_id.required' => 'La :attribute es obligatoria.',
        'unidad_medida_id.exists' => 'La :attribute seleccionada no es válida.',
        'precio_compra.required' => 'El :attribute es obligatorio.',
        'precio_compra.numeric' => 'El :attribute debe ser un número.',
        'precio_compra.min' => 'El :attribute debe ser un valor positivo.',
        'precio_venta.required' => 'El :attribute es obligatorio.',
        'precio_venta.numeric' => 'El :attribute debe ser un número.',
        'precio_venta.min' => 'El :attribute debe ser un valor positivo.',
    ];
   
    public function mount()
    {
        $this->unidades = UnidadMedida::all();
    }

    public function crear()
    {
        $this->reset(['nombre', 'unidad_medida_id', 'precio_compra', 'precio_venta']);
    }

    public function guardar()
    {
        $this->validate();

        $producto = Producto::create([
            'nombre' => $this->nombre,
            'unidad_medida_id' => $this->unidad_medida_id,
            'precio_compra' => $this->precio_compra,
            'precio_venta' => $this->precio_venta,
        ]);

        // Crear inventario inicial con stock 0
        Inventario::create([
            'producto_id' => $producto->id,
            'stock' => 0,
        ]);

        $this->dispatch('alertaLivewire', "Creado");

        // Limpiar los campos después de guardar
        $this->crear();
    }

    public function render()
    {
        return view('livewire.producto-crear-livewire');
    }
}
