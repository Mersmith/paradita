@section('tituloPagina', 'Compra editar')

@section('anchoPantalla', '100%')

<div>
    <div class="g_panel cabecera_titulo_pagina">
        <h2>Editar Compra</h2>
        <div class="cabecera_titulo_botones">
            <a href="#" class="g_boton g_boton_light">Inicio <i class="fa-solid fa-house"></i></a>

            <a href="{{ route('compra-crear.vista.crear') }}" class="g_boton g_boton_primary">
                Crear <i class="fa-solid fa-square-plus"></i></a>

            <a href="{{ route('compra.vista.todas') }}" class="g_boton g_boton_darkt">
                <i class="fa-solid fa-arrow-left"></i> Regresar</a>
        </div>
    </div>

    <div class="formulario">
        <form wire:submit.prevent="guardar">
            <div class="g_fila">
                <div class="g_columna_12">
                    <div class="g_panel">
                        <h4 class="g_panel_titulo">General</h4>
                        <div class="g_margin_bottom_20">
                            <label for="fecha">Fecha <span class="obligatorio">*</span></label>
                            <input type="date" id="fecha" wire:model.live="fecha">
                            @error('fecha') <p class="mensaje_error">{{ $message }}</p> @enderror
                        </div>

                        <div class="g_margin_bottom_20">
                            <label for="estado">Estado <span class="obligatorio"><i class="fa-solid fa-asterisk"></i></span></label>
                            <select id="estado" wire:model.live="estado">
                                @foreach ($estadosDisponibles as $estadoDisponible)
                                <option value="{{ $estadoDisponible }}">{{ ucfirst($estadoDisponible) }}</option>
                                @endforeach
                            </select>
                            @error('estado') <p class="mensaje_error">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="g_panel">
                <h4 class="g_panel_titulo">Detalle de Compra</h4>
                <div class="tabla_contenido">
                    <table class="tabla">
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
                                    <select wire:model.live="detalles.{{ $index }}.producto_id" @disabled($estado !=='borrador' )>
                                        <option value="">Seleccione</option>
                                        @foreach ($productos as $producto)
                                        <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select wire:model.live="detalles.{{ $index }}.unidad_medida_id" @disabled($estado !=='borrador' )>
                                        <option value="">Seleccione</option>
                                        @foreach ($unidades as $unidad)
                                        <option value="{{ $unidad->id }}" {{ $unidad->id == $detalle['unidad_medida_id'] ? 'selected' : '' }}>
                                            {{ $unidad->nombre }}
                                        </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="number" step="0.01" wire:model.live="detalles.{{ $index }}.cantidad" @disabled($estado !=='borrador' )>
                                </td>
                                <td>
                                    <input type="number" step="0.01" wire:model.live="detalles.{{ $index }}.precio_compra" @disabled($estado !=='borrador' )>
                                </td>
                                <td>
                                    {{ number_format($detalle['cantidad'] * $detalle['precio_compra'], 2) }}
                                </td>
                                <td>
                                    <input type="number" step="0.01" wire:model.live="detalles.{{ $index }}.precio_venta" @disabled($estado !=='borrador' )>
                                </td>
                                <td>
                                    {{ number_format($detalle['cantidad'] * $detalle['precio_venta'], 2) }}
                                </td>
                                <td>
                                    <strong>
                                        {{ number_format(($detalle['precio_venta'] - $detalle['precio_compra']) * $detalle['cantidad'], 2) }}
                                    </strong>
                                </td>
                                <td>
                                    <button type="button" wire:click="eliminarDetalle({{ $index }})" @disabled($estado !=='borrador' )>❌</button>
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

                </div>
            </div>

            <div class="formulario_botones">
                @if($estado == 'borrador')
                <button type="button" wire:click="agregarDetalle">➕ Agregar Producto</button>
                @endif

                @if(count($estadosDisponibles) > 1)
                <button type="submit" class="guardar" @disabled($estado=='confirmado' )>Guardar Cambios</button>
                @endif </div>
        </form>
    </div>
</div>
