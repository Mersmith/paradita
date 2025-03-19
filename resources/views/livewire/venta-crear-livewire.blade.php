@section('tituloPagina', 'Venta crear')

@section('anchoPantalla', '100%')

<div>
    <!--CABECERA TITULO PAGINA-->
    <div class="g_panel cabecera_titulo_pagina">
        <!--TITULO-->
        <h2>Venta nueva</h2>

        <!--BOTONES-->
        <div class="cabecera_titulo_botones">
            <a href="#" class="g_boton g_boton_light">
                Inicio <i class="fa-solid fa-house"></i></a>

            <a href="{{ route('venta.vista.todas') }}" class="g_boton g_boton_darkt">
                <i class="fa-solid fa-arrow-left"></i> Regresar</a>
        </div>
    </div>

    <!--FORMULARIO-->
    <div class="formulario">
        <form wire:submit.prevent="guardar">
            <div class="g_fila">
                <div class="g_columna_12">
                    <div class="g_panel">
                        <h4 class="g_panel_titulo">General</h4>
                        <div class="">
                            <label for="nombre">Fecha <span class="obligatorio"><i class="fa-solid fa-asterisk"></i></span></label>
                            <input type="date" id="fecha" name="fecha" wire:model="fecha">
                            @error('fecha') <p class="mensaje_error">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!--TABLA-->
            <div class="g_panel">
                <h4 class="g_panel_titulo">Detalle</h4>
                <div class="tabla_contenido">
                    <div class="contenedor_tabla">
                        <table class="tabla">
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
                            
                            <tfoot>
                                <tr>
                                    <td colspan="3"><strong>Total de registros: {{ count($detalles) }}</strong></td> <!-- Contador de filas -->
                                    <td></td>
                                    <td><strong>{{ number_format($this->totalSubtotalVenta, 2) }}</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <div class="formulario_botones">
                <button type="button" wire:click="agregarDetalle">➕ Agregar Producto</button>
                <button type="submit" class="guardar">Guardar Venta</button>
            </div>
        </form>
    </div>
</div>
