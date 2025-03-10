<?php

namespace App\Livewire;

use App\Models\Inventario;
use App\Models\Producto;
use App\Models\UnidadMedida;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.erp.layout-erp')]
class ProductoLivewire extends Component
{
    public $productos, $nombre, $unidad_medida_id, $precio_compra, $precio_venta, $producto_id; // Agregar $precio_venta
    public $modal = false;
    public $unidades;

    public function mount()
    {
        $this->unidades = UnidadMedida::all();
        $this->productos = Producto::all();
    }

    // Abrir modal para crear producto
    public function crear()
    {
        $this->reset(['nombre', 'unidad_medida_id', 'precio_compra','precio_venta', 'producto_id']);
        $this->abrirModal();
    }
    public function guardar()
    {
        $this->validate([
            'nombre' => 'required|string|max:255',
            'unidad_medida_id' => 'required|exists:unidad_medidas,id',
            'precio_compra' => 'required|numeric|min:0', // Validar precio_venta
            'precio_venta' => 'required|numeric|min:0', // Validar precio_venta
        ]);
    
        $producto = Producto::updateOrCreate(
            ['id' => $this->producto_id],
            [
                'nombre' => $this->nombre,
                'unidad_medida_id' => $this->unidad_medida_id,
                'precio_compra' => $this->precio_compra,
                'precio_venta' => $this->precio_venta
            ]
        );
    
        if (!$this->producto_id) {
            Inventario::create([
                'producto_id' => $producto->id,
                'stock' => 0,
            ]);
        }
    
        session()->flash('message', $this->producto_id ? 'Producto actualizado' : 'Producto creado con inventario inicial');
        $this->cerrarModal();
    }
    

    // Editar producto
    public function editar($id)
    {
        $producto = Producto::findOrFail($id);
        $this->producto_id = $id;
        $this->nombre = $producto->nombre;
        $this->unidad_medida_id = $producto->unidad_medida_id;
        $this->precio_compra = $producto->precio_compra; // Cargar precio_venta
        $this->precio_venta = $producto->precio_venta; // Cargar precio_venta
        $this->abrirModal();
    }
    

    // Eliminar producto
    public function eliminar($id)
    {
        Producto::find($id)->delete();
        session()->flash('message', 'Producto eliminado');
    }

    // Métodos para manejar el modal
    public function abrirModal()
    {$this->modal = true;}

    public function cerrarModal()
    {$this->modal = false;}

    public function render()
    {
        $this->productos = Producto::all();
        $unidades = UnidadMedida::all();

        return view('livewire.producto-livewire', compact('unidades'));
    }
}
