<?php

namespace App\Livewire;

use App\Models\Producto;
use App\Models\UnidadMedida;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\Attributes\On;

#[Layout('layouts.erp.layout-erp')]
class ProductoEditarLivewire extends Component
{
    public $producto;
    public $nombre, $unidad_medida_id, $precio_compra, $precio_venta;
    public $unidades = [];

    protected $rules = [
        'nombre' => 'required|string|max:255|unique:productos,nombre,{{producto_id}}',
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

    public function mount($id)
    {
        $this->producto = Producto::findOrFail($id);

        $this->nombre = $this->producto->nombre;
        $this->unidad_medida_id = $this->producto->unidad_medida_id;
        $this->precio_compra = $this->producto->precio_compra;
        $this->precio_venta = $this->producto->precio_venta;

        $this->unidades = UnidadMedida::all();
    }

    public function guardar()
    {
        $this->validate([
            'nombre' => 'required|string|max:255|unique:productos,nombre,' . $this->producto->id,
            'unidad_medida_id' => 'required|exists:unidad_medidas,id',
            'precio_compra' => 'required|numeric|min:0',
            'precio_venta' => 'required|numeric|min:0',
        ]);

        $this->producto->update([
            'nombre' => $this->nombre,
            'unidad_medida_id' => $this->unidad_medida_id,
            'precio_compra' => $this->precio_compra,
            'precio_venta' => $this->precio_venta,
        ]);

        return redirect()->route('producto.vista.todas');
    }

    #[On('eliminarProductoOn')]
    public function eliminarProductoOn($id)
    {
        $producto = Producto::where('id', $id)->first();
        $producto->delete();

        return redirect()->route('producto.vista.todas');
    }

    public function render()
    {
        return view('livewire.producto-editar-livewire');
    }
}
