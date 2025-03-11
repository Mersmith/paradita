@section('tituloPagina', 'Crear producto')

<div>
    <!--CABECERA TITULO PAGINA-->
    <div class="g_panel cabecera_titulo_pagina">
        <h2>Crear producto</h2>
        <div class="cabecera_titulo_botones">
            <div class="cabecera_titulo_botones">
                <a href="{{ route('producto.vista.todas') }}" class="g_boton g_boton_light">Inicio <i class="fa-solid fa-house"></i></a>
                <a href="{{ route('producto.vista.todas') }}" class="g_boton g_boton_darkt"><i class="fa-solid fa-arrow-left"></i> Regresar</a>
            </div>
        </div>
    </div>

    <!--FORMULARIO-->
    <div class="formulario">
        <div class="g_fila">
            <div class="g_columna_8">
                <div class="g_panel">
                    <h4 class="g_panel_titulo">General</h4>

                    <!--NOMBRE-->
                    <div class="g_margin_bottom_20">
                        <label for="nombre">Nombre <span class="obligatorio"><i class="fa-solid fa-asterisk"></i></span></label>
                        <input type="text" id="nombre" name="nombre" wire:model="nombre">
                        <p class="leyenda">El producto debe tener un nombre único.</p>
                        @error('nombre') <p class="mensaje_error">{{ $message }}</p> @enderror
                    </div>

                    <!--PRECIO COMPRA-->
                    <div class="g_margin_bottom_20">
                        <label for="precio_compra">Precio de compra <span class="obligatorio"><i class="fa-solid fa-asterisk"></i></span></label>
                        <input type="text" id="precio_compra" name="precio_compra" wire:model="precio_compra">
                        @error('precio_compra') <p class="mensaje_error">{{ $message }}</p> @enderror
                    </div>

                    <!--PRECIO VENTA-->
                    <div class="g_margin_bottom_20">
                        <label for="precio_venta">Precio de venta <span class="obligatorio"><i class="fa-solid fa-asterisk"></i></span></label>
                        <input type="text" id="precio_venta" name="precio_venta" wire:model="precio_venta">
                        @error('precio_venta') <p class="mensaje_error">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <div class="g_columna_4">
                <div class="g_panel">
                    <h4 class="g_panel_titulo">Detalle</h4>
                    <div>
                        <label for="unidad_medida_id">Unidad de medida <span class="obligatorio"><i class="fa-solid fa-asterisk"></i></span></label>
                        <select id="unidad_medida_id" name="unidad_medida_id" wire:model="unidad_medida_id">
                            <option value="" selected disabled>Seleccione</option>
                            @foreach ($unidades as $unidad)
                            <option value="{{ $unidad->id }}">{{ $unidad->nombre }}</option>
                            @endforeach
                        </select>
                        @error('unidad_medida_id') <p class="mensaje_error">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="formulario_botones">
            <button wire:click="guardar" class="guardar">Guardar</button>
            <a href="{{ route('producto.vista.todas') }}" class="cancelar">Cancelar</a>
        </div>
    </div>
</div>
