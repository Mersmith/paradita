@section('tituloPagina', 'Editar unidad medida')

<div>
    <!--CABECERA TITULO PAGINA-->
    <div class="g_panel cabecera_titulo_pagina">
        <h2>Editar unidad medida</h2>

        <div class="cabecera_titulo_botones">
            <a href="{{ route('unidad-medida.vista.todas') }}" class="g_boton g_boton_light">Inicio <i class="fa-solid fa-house"></i></a>
            <a href="{{ route('unidad-medida.vista.crear') }}" class="g_boton g_boton_primary">
                Crear <i class="fa-solid fa-square-plus"></i></a>
            <button class="g_boton g_boton_danger" wire:click="$dispatch('eliminarUnidadAlertaLivewire', { id: {{ $unidad->id }} })">
                Eliminar <i class="fa-solid fa-trash-can"></i>
            </button>
            <a href="{{ route('unidad-medida.vista.todas') }}" class="g_boton g_boton_darkt"><i class="fa-solid fa-arrow-left"></i> Regresar</a>
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
                        <p class="leyenda">La unidad debe tener un nombre único.</p>
                        @error('nombre') <p class="mensaje_error">{{ $message }}</p> @enderror
                    </div>
            </div>
        </div>

        <div class="formulario_botones">
            <button wire:click="guardar" class="guardar">Guardar</button>
            <a href="{{ route('unidad-medida.vista.todas') }}" class="cancelar">Cancelar</a>
        </div>
    </div>

    @script
    <script>
        Livewire.on('eliminarUnidadAlertaLivewire', (id) => {
            Swal.fire({
                title: '¿Quieres quitar?'
                , text: "No podrás recuparlo."
                , icon: 'warning'
                , showCancelButton: true
                , confirmButtonColor: '#3085d6'
                , cancelButtonColor: '#d33'
                , confirmButtonText: '¡Sí, eliminar!'
                , cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch('eliminarUnidadOn', {
                        id: id
                    });
                }
            })
        })
    </script>
    @endscript
</div>
