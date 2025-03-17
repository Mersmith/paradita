<?php

namespace App\Livewire;

use App\Models\Compra;
use App\Models\DetalleCompra;
use App\Models\Inventario;
use App\Models\Producto;
use App\Models\UnidadMedida;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.erp.layout-erp')]
class CompraCrearLivewire extends Component
{
    public $productos, $unidades, $fecha, $compra_id;
    public $detalles = []; // Lista de productos comprados

    public function mount()
    {
        $this->productos = Producto::all();
        $this->unidades = UnidadMedida::all();
        $this->fecha = Carbon::now()->format('Y-m-d');
        $this->detalles = [
            [
                'producto_id' => '',
                'unidad_medida_id' => '',
                'cantidad' => 1,
                'precio_compra' => 0,
                'precio_venta' => 0, // Agregar precio_venta
            ],
        ];
    }

    public function agregarDetalle()
    {
        $this->detalles[] = [
            'producto_id' => '',
            'unidad_medida_id' => '',
            'cantidad' => 1,
            'precio_compra' => 0,
            'precio_venta' => 0, // Agregar precio_venta
        ];
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
            'detalles.*.precio_compra' => 'required|numeric|min:0.01',
        ]);

        // Crear la compra
        $compra = Compra::create(['fecha' => $this->fecha]);

        // Guardar los detalles de la compra y actualizar el inventario
        foreach ($this->detalles as $detalle) {
            $producto = Producto::find($detalle['producto_id']);

            // Aquí deberías convertir la cantidad a la unidad base si es necesario
            $cantidad_convertida = $detalle['cantidad']; // Suponiendo que ya está en unidad base

            // Crear detalle de compra
            DetalleCompra::create([
                'compra_id' => $compra->id,
                'producto_id' => $detalle['producto_id'],
                'unidad_medida_id' => $detalle['unidad_medida_id'],
                'cantidad' => $detalle['cantidad'],
                'cantidad_convertida' => $cantidad_convertida,
                'precio_unitario' => $detalle['precio_compra'],
                'precio_total' => $detalle['cantidad'] * $detalle['precio_compra'],
            ]);

            // Actualizar inventario
            /*$inventario = Inventario::where('producto_id', $detalle['producto_id'])->first();
            if ($inventario) {
                $inventario->stock += $cantidad_convertida;
                $inventario->save();
            }*/
        }

        //session()->flash('message', 'Compra registrada con éxito.');
        //return redirect()->route('compras');
    }

    public function updatedDetalles($value, $key)
    {
        [$index, $field] = explode('.', $key);

        if ($field === 'producto_id') {
            $producto = Producto::find($value);
            if ($producto) {
                $this->detalles[$index]['unidad_medida_id'] = $producto->unidad_medida_id;
                $this->detalles[$index]['precio_compra'] = $producto->precio_compra;
                $this->detalles[$index]['precio_venta'] = $producto->precio_venta; // Agregar precio_venta
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
        return collect($this->detalles)->sum(function ($detalle) {
            return $detalle['cantidad'] * $detalle['precio_compra'];
        });
    }

    public function getTotalSubtotalVentaProperty()
    {
        return collect($this->detalles)->sum(function ($detalle) {
            return $detalle['cantidad'] * $detalle['precio_venta'];
        });
    }

    public function getTotalSubtotalMargenGananciaProperty()
    {
        return collect($this->detalles)->sum(function ($detalle) {
            return ($detalle['precio_venta'] - $detalle['precio_compra']) * $detalle['cantidad'];
        });
    }

    public function render()
    {
        return view('livewire.compra-crear-livewire');
    }
}
