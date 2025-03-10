<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Venta;
use App\Models\DetalleVenta;
use App\Models\Producto;
use App\Models\Inventario;
use App\Models\UnidadMedida;
use Carbon\Carbon;
use Livewire\Attributes\Layout;

#[Layout('layouts.erp.layout-erp')]
class VentaCrearLivewire extends Component
{
    public $productos, $unidades, $fecha;
    public $detalles = []; // Lista de productos vendidos

    public function mount()
    {
        $this->productos = Producto::all();
        $this->unidades = UnidadMedida::all();
        $this->fecha = Carbon::now()->format('Y-m-d');
        $this->detalles = [
            ['producto_id' => '', 'unidad_medida_id' => '', 'cantidad' => 1, 'precio_venta' => 0]
        ];
    }

    public function agregarDetalle()
    {
        $this->detalles[] = ['producto_id' => '', 'unidad_medida_id' => '', 'cantidad' => 1, 'precio_venta' => 0];
    }

    public function eliminarDetalle($index)
    {
        unset($this->detalles[$index]);
        $this->detalles = array_values($this->detalles);
    }

    public function guardar()
    {
        $this->validate([
            'fecha' => 'required|date',
            'detalles' => 'required|array|min:1',
            'detalles.*.producto_id' => 'required|exists:productos,id',
            'detalles.*.unidad_medida_id' => 'required|exists:unidad_medidas,id',
            'detalles.*.cantidad' => 'required|numeric|min:0.01',
            'detalles.*.precio_venta' => 'required|numeric|min:0.01',
        ]);

        // Crear la venta
        $venta = Venta::create(['fecha' => $this->fecha]);

        // Guardar los detalles de la venta y actualizar el inventario
        foreach ($this->detalles as $detalle) {
            $producto = Producto::find($detalle['producto_id']);

            // Aquí deberías convertir la cantidad a la unidad base si es necesario
            $cantidad_convertida = $detalle['cantidad']; // Suponiendo que ya está en unidad base

            // Verificar si hay stock suficiente antes de registrar la venta
            $inventario = Inventario::where('producto_id', $detalle['producto_id'])->first();

            if ($inventario && $inventario->stock >= $cantidad_convertida) {
                // Crear detalle de venta
                DetalleVenta::create([
                    'venta_id' => $venta->id,
                    'producto_id' => $detalle['producto_id'],
                    'unidad_medida_id' => $detalle['unidad_medida_id'],
                    'cantidad' => $detalle['cantidad'],
                    'cantidad_convertida' => $cantidad_convertida,
                    'precio_unitario' => $detalle['precio_venta'],
                ]);

                // Descontar stock
                $inventario->stock -= $cantidad_convertida;
                $inventario->save();
            } else {
                session()->flash('error', 'No hay suficiente stock para el producto: ' . $producto->nombre);
                return;
            }
        }

        session()->flash('message', 'Venta registrada con éxito.');
        //return redirect()->route('ventas');
    }

    public function updatedDetalles($value, $key)
    {
        // Extraer el índice y el campo del detalle modificado
        [$index, $field] = explode('.', $key);
    
        // Si el campo modificado es 'producto_id', actualizar 'unidad_medida_id' y 'precio_venta'
        if ($field === 'producto_id') {
            $producto = Producto::find($value);
            if ($producto) {
                $this->detalles[$index]['unidad_medida_id'] = $producto->unidad_medida_id;
                $this->detalles[$index]['precio_venta'] = $producto->precio_venta; // Asignar precio referencial
            }
        }
    }

    public function render()
    {
        return view('livewire.venta-crear-livewire');
    }
}
