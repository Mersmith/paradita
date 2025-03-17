<?php

namespace App\Livewire;

use App\Models\Compra;
use App\Models\DetalleCompra;
use App\Models\Producto;
use App\Models\UnidadMedida;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.erp.layout-erp')]
class CompraDetalleEditarLivewire extends Component
{
    public $compra, $fecha, $detalles = [];
    public $productos, $unidades;

    public function mount($id)
    {
        $this->compra = Compra::find($id);

        if (!$this->compra) {
            abort(404, 'Compra no encontrada');
        }

        $this->productos = Producto::all();
        $this->unidades = UnidadMedida::all();
        $this->fecha = $this->compra->fecha;

        // Cargar detalles de la compra
        $this->detalles = $this->compra->detalleCompras->map(function ($detalle) {
            return [
                'id' => $detalle->id,
                'producto_id' => $detalle->producto_id,
                'unidad_medida_id' => $detalle->unidad_medida_id,
                'cantidad' => $detalle->cantidad,
                'precio_compra' => $detalle->precio_unitario,
                'precio_venta' => $detalle->producto->precio_venta ?? 0, // Obtener precio_venta
            ];
        })->toArray();
    }

    public function agregarDetalle()
    {
        $this->detalles[] = [
            'id' => null,
            'producto_id' => '',
            'unidad_medida_id' => '',
            'cantidad' => 1,
            'precio_compra' => 0,
            'precio_venta' => 0,
        ];
    }

    public function eliminarDetalle($index)
    {
        unset($this->detalles[$index]);
        $this->detalles = array_values($this->detalles); // Reindexar array
    }

    public function guardar()
    {
        $this->validate([
            'fecha' => 'required|date',
            'detalles' => 'required|array|min:1',
            'detalles.*.producto_id' => 'required|exists:productos,id',
            'detalles.*.unidad_medida_id' => 'required|exists:unidad_medidas,id',
            'detalles.*.cantidad' => 'required|numeric|min:0.01',
            'detalles.*.precio_compra' => 'required|numeric|min:0.01',
        ]);

        // Actualizar la compra
        $this->compra->update(['fecha' => $this->fecha]);

        // Guardar detalles
        foreach ($this->detalles as $detalle) {
            if ($detalle['id']) {
                // Actualizar detalle existente
                DetalleCompra::find($detalle['id'])->update([
                    'producto_id' => $detalle['producto_id'],
                    'unidad_medida_id' => $detalle['unidad_medida_id'],
                    'cantidad' => $detalle['cantidad'],
                    'precio_unitario' => $detalle['precio_compra'],
                    'precio_total' => $detalle['cantidad'] * $detalle['precio_compra'],
                ]);
            } else {
                // Crear nuevo detalle
                DetalleCompra::create([
                    'compra_id' => $this->compra->id,
                    'producto_id' => $detalle['producto_id'],
                    'unidad_medida_id' => $detalle['unidad_medida_id'],
                    'cantidad' => $detalle['cantidad'],
                    'precio_unitario' => $detalle['precio_compra'],
                    'precio_total' => $detalle['cantidad'] * $detalle['precio_compra'],
                ]);
            }
        }

        session()->flash('message', 'Compra actualizada con éxito.');
    }

    public function updatedDetalles($value, $key)
    {
        [$index, $field] = explode('.', $key);

        if ($field === 'producto_id') {
            $producto = Producto::find($value);
            if ($producto) {
                $this->detalles[$index]['unidad_medida_id'] = $producto->unidad_medida_id;
                $this->detalles[$index]['precio_compra'] = $producto->precio_compra;
                $this->detalles[$index]['precio_venta'] = $producto->precio_venta;
            }
        }
    }    

    public function getTotalCantidadProperty()
    {
        return collect($this->detalles)->sum('cantidad');
    }

    public function getTotalPrecioCompraProperty()
    {
        return collect($this->detalles)->sum('precio_compra');
    }

    public function getTotalPrecioVentaProperty()
    {
        return collect($this->detalles)->sum('precio_venta');
    }

    public function getTotalSubtotalCompraProperty()
    {
        return collect($this->detalles)->sum(fn($detalle) => $detalle['cantidad'] * $detalle['precio_compra']);
    }

    public function getTotalSubtotalVentaProperty()
    {
        return collect($this->detalles)->sum(fn($detalle) => $detalle['cantidad'] * $detalle['precio_venta']);
    }

    public function getTotalSubtotalMargenGananciaProperty()
    {
        return collect($this->detalles)->sum(fn($detalle) => ($detalle['precio_venta'] - $detalle['precio_compra']) * $detalle['cantidad']);
    }

    public function render()
    {
        return view('livewire.compra-detalle-editar-livewire');
    }
}
