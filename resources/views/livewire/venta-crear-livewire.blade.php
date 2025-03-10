<div>
    <h2>Registrar Venta</h2>

    @if (session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form wire:submit.prevent="guardar">
        <label>Fecha de Venta:</label>
        <input type="date" wire:model="fecha" required>

        <h3>Detalles de Venta</h3>
        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Unidad</th>
                    <th>Cantidad</th>
                    <th>Precio Venta</th>
                    <th>Subtotal</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($detalles as $index => $detalle)
                    <tr>
                        <td>
                            <select wire:model.live="detalles.{{ $index }}.producto_id">
                                <option value="">Seleccione</option>
                                @foreach ($productos as $producto)
                                    <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select wire:model.live="detalles.{{ $index }}.unidad_medida_id">
                                <option value="">Seleccione</option>
                                @foreach ($unidades as $unidad)
                                    <option value="{{ $unidad->id }}">{{ $unidad->nombre }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="number" step="0.01" wire:model.live="detalles.{{ $index }}.cantidad">
                        </td>
                        <td>
                            <input type="number" step="0.01" wire:model.live="detalles.{{ $index }}.precio_venta">
                        </td>
                        <td>
                            {{ number_format($detalle['cantidad'] * $detalle['precio_venta'], 2) }}
                        </td>
                        <td>
                            <button type="button" wire:click="eliminarDetalle({{ $index }})">❌</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <button type="button" wire:click="agregarDetalle">➕ Agregar Producto</button>
        <button type="submit">Guardar Venta</button>
    </form>
</div>
