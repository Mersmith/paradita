<div>
    <h2>Registrar Compra</h2>

    @if (session()->has('message'))
    <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <form wire:submit.prevent="guardar">
        <label>Fecha de Compra:</label>
        <input type="date" wire:model="fecha" required>

        <h3>Detalles de Compra</h3>
        <table>
            <thead>
                <tr>
                    <th>N°</th> <!-- Nueva columna -->
                    <th>Producto</th>
                    <th>Unidad</th>
                    <th>Cantidad</th>
                    <th>Precio Compra</th>
                    <th>Subtotal Compra</th>
                    <th>Precio Venta</th>
                    <th>Subtotal Venta</th>
                    <th>Margen de Ganancia</th> <!-- Nueva columna -->
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($detalles as $index => $detalle)
                <tr>
                    <td>{{ $loop->iteration }}</td> <!-- N° automático -->
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
                            <option value="{{ $unidad->id }}" {{ $unidad->id == $detalle['unidad_medida_id'] ? 'selected' : '' }}>
                                {{ $unidad->nombre }}
                            </option>
                            @endforeach
                        </select>
                    </td>
        
                    <td>
                        <input type="number" step="0.01" wire:model.live="detalles.{{ $index }}.cantidad">
                    </td>
                    <td>
                        <input type="number" step="0.01" wire:model.live="detalles.{{ $index }}.precio_compra">
                    </td>
                    
                    <td>
                        {{ number_format($detalle['cantidad'] * $detalle['precio_compra'], 2) }}
                    </td>
                    <td>
                        <input type="number" step="0.01" wire:model.live="detalles.{{ $index }}.precio_venta">
                    </td>
                    <td>
                        {{ number_format($detalle['cantidad'] * $detalle['precio_venta'], 2) }}
                    </td>
                    <td>
                        <strong>
                            {{ number_format(($detalle['precio_venta'] - $detalle['precio_compra']) * $detalle['cantidad'], 2) }}
                        </strong>
                    </td> <!-- Nueva columna -->
                    <td>
                        <button type="button" wire:click="eliminarDetalle({{ $index }})">❌</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        
            <tfoot>
                <tr>
                    <td colspan="3"><strong>Total de registros: {{ count($detalles) }}</strong></td> <!-- Contador de filas -->
                    <td><strong></strong></td>
                    <td><strong></strong></td>
                    <td><strong>{{ number_format($this->totalSubtotalCompra, 2) }}</strong></td>
                    <td><strong></strong></td>
                    <td><strong>{{ number_format($this->totalSubtotalVenta, 2) }}</strong></td>
                    <td><strong>{{ number_format($this->totalSubtotalMargenGanancia, 2) }}</strong></td>
                    <td></td>
                </tr>
            </tfoot>
            
        </table>
        

        <button type="button" wire:click="agregarDetalle">➕ Agregar Producto</button>
        <button type="submit">Guardar Compra</button>
    </form>
</div>
