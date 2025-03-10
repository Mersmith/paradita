<div>
    <!--CABECERA TITULO PAGINA-->
    <div class="g_panel cabecera_titulo_pagina">
        <!--TITULO-->
        <h2>Unidades</h2>

        <!--BOTONES-->
        <div class="cabecera_titulo_botones">
            <a href="#" class="g_boton g_boton_light">
                Inicio <i class="fa-solid fa-house"></i></a>

            <a href="#" class="g_boton g_boton_primary">
                Crear <i class="fa-solid fa-square-plus"></i></a>
        </div>
    </div>

    <!--FORMULARIO-->
    <div class="formulario">
        <div class="g_panel">
            <div class="g_fila">
                <div class="g_columna_12">

                    <!--TITULO-->
                    <h4 class="g_panel_titulo">Crear / Editar</h4>

                    <div class="g_margin_bottom_20">
                        <input type="text" wire:model="nombre" class="border p-2 w-full" placeholder="Nombre de la unidad">
                        @error('nombre')
                        <p class="mensaje_error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div>
                <div class="formulario_botones">
                    <button wire:click="{{ $modo_edicion ? 'actualizarUnidad' : 'guardarUnidad' }}" class="guardar">
                        {{ $modo_edicion ? 'Actualizar' : 'Guardar' }}
                    </button>

                    @if ($modo_edicion)
                    <button wire:click="$set('modo_edicion', false)" class="cancelar">
                        Cancelar
                    </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!--TABLA-->
    <div class="g_panel">
        <!--TABLA CONTENIDO-->
        <div class="tabla_contenido">
            <div class="contenedor_tabla">
                <!--TABLA-->
                <table class="tabla">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($unidades as $unidad)
                        <tr>
                            <td>{{ $unidad->id }}</td>
                            <td>{{ $unidad->nombre }}</td>
                            <td>
                                <button wire:click="editarUnidad({{ $unidad->id }})" class="g_accion_editar">
                                    <span><i class="fa-solid fa-pencil"></i></span>
                                </button>
                                <button wire:click="eliminarUnidad({{ $unidad->id }})" class="g_desactivado">
                                    <span><i class="fa-solid fa-trash-can"></i></span>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $unidades->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
