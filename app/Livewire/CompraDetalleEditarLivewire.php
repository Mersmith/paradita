<?php

namespace App\Livewire;

use App\Models\Compra;
use App\Models\DetalleCompra;
use App\Models\Inventario;
use App\Models\Producto;
use App\Models\UnidadMedida;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.erp.layout-erp')]
class CompraDetalleEditarLivewire extends Component
{
    public $compra, $fecha, $detalles = [];
    public $productos, $unidades;
    public $estado;
    public $estadosDisponibles = [];
    public function mount($id)
    {
        $this->compra = Compra::find($id);

        if (!$this->compra) {
            abort(404, 'Compra no encontrada');
        }

        $this->productos = Producto::all();
        $this->unidades = UnidadMedida::all();
        $this->fecha = $this->compra->fecha;
        $this->estado = $this->compra->estado;

        $this->cargarEstadosDisponibles();

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

    public function cargarEstadosDisponibles()
    {
        // Definir reglas de transición de estados
        $transiciones = [
            'borrador' => ['borrador', 'confirmado'],
            'confirmado' => ['confirmado', 'cancelado', 'eliminado'],
            'cancelado' => ['cancelado', 'eliminado'],
            'eliminado' => ['eliminado'],
        ];

        // Obtener los estados permitidos según el estado actual
        $this->estadosDisponibles = $transiciones[$this->estado] ?? [];
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
            'estado' => 'required|in:borrador,confirmado,cancelado,eliminado', // Validar estados permitidos
            'detalles' => 'required|array|min:1',
            'detalles.*.producto_id' => 'required|exists:productos,id',
            'detalles.*.unidad_medida_id' => 'required|exists:unidad_medidas,id',
            'detalles.*.cantidad' => 'required|numeric|min:0.01',
            'detalles.*.precio_compra' => 'required|numeric|min:0.01',
        ]);

        // Guardar estado anterior
        $estadoAnterior = $this->compra->estado;

        // Actualizar la compra
        $this->compra->update([
            'fecha' => $this->fecha,
            'estado' => $this->estado,
        ]);

        // Obtener los IDs de los detalles actuales en la base de datos
        $detallesExistentes = $this->compra->detalleCompras->pluck('id')->toArray();

        // Obtener los IDs de los detalles enviados desde la interfaz
        $detallesEnviados = collect($this->detalles)->pluck('id')->filter()->toArray();

        // Identificar los detalles que deben eliminarse (existen en la BD pero no en la interfaz)
        $detallesAEliminar = array_diff($detallesExistentes, $detallesEnviados);

        // **Eliminar detalles que ya no están en la lista y restar stock**
        foreach ($detallesAEliminar as $detalleId) {
            $detalle = DetalleCompra::find($detalleId);
            if ($detalle && $estadoAnterior === 'confirmado') {
                $this->revertirInventario($detalle); // Restar stock
            }
            $detalle->delete();
        }

        // Guardar o actualizar detalles
        foreach ($this->detalles as $detalle) {
            if (isset($detalle['id'])) {
                // Obtener el detalle existente antes de actualizar
                $detalleActualizado = DetalleCompra::find($detalle['id']);

                // Actualizar detalle
                $detalleActualizado->update([
                    'producto_id' => $detalle['producto_id'],
                    'unidad_medida_id' => $detalle['unidad_medida_id'],
                    'cantidad' => $detalle['cantidad'],
                    'precio_unitario' => $detalle['precio_compra'],
                    'precio_total' => $detalle['cantidad'] * $detalle['precio_compra'],
                ]);

                // **Actualizar inventario correctamente**
                if ($this->estado === 'confirmado') {
                    $this->actualizarInventario($detalleActualizado);
                }

            } else {
                // Crear nuevo detalle
                $detalleCreado = DetalleCompra::create([
                    'compra_id' => $this->compra->id,
                    'producto_id' => $detalle['producto_id'],
                    'unidad_medida_id' => $detalle['unidad_medida_id'],
                    'cantidad' => $detalle['cantidad'],
                    'precio_unitario' => $detalle['precio_compra'],
                    'precio_total' => $detalle['cantidad'] * $detalle['precio_compra'],
                ]);

                // **Actualizar inventario correctamente**
                if ($this->estado === 'confirmado') {
                    $this->actualizarInventario($detalleCreado);
                }
            }
        }

        // **Si el estado cambió de "confirmado" a "cancelado" o "eliminado", restar stock**
        if (in_array($this->estado, ['cancelado', 'eliminado']) && $estadoAnterior === 'confirmado') {
            foreach ($this->compra->detalleCompras as $detalle) {
                $this->revertirInventario($detalle);
            }
        }

        $this->dispatch('alertaLivewire', "Actualizado");
    }

    private function actualizarInventario($detalle)
    {
        $inventario = Inventario::where('producto_id', $detalle->producto_id)->first();

        if ($inventario) {
            // **Solo sumar la nueva cantidad**
            $inventario->stock += $detalle->cantidad;
            $inventario->save();
        } else {
            // Si el producto no tiene inventario, crear un nuevo registro
            Inventario::create([
                'producto_id' => $detalle->producto_id,
                'stock' => $detalle->cantidad,
            ]);
        }
    }

    private function revertirInventario($detalle)
    {
        $inventario = Inventario::where('producto_id', $detalle->producto_id)->first();

        if ($inventario) {
            // **Restar la cantidad del stock solo si hay suficiente**
            $inventario->stock -= $detalle->cantidad;
            if ($inventario->stock < 0) {
                $inventario->stock = 0; // Evitar stock negativo
            }
            $inventario->save();
        }
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
