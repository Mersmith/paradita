@section('tituloPagina', 'Inventario')

@section('anchoPantalla', '100%')

<div>
    <!--CABECERA TITULO PAGINA-->
    <div class="g_panel cabecera_titulo_pagina">
        <!--TITULO-->
        <h2>Inventario</h2>

        <!--BOTONES-->
        <div class="cabecera_titulo_botones">
            <a href="{{ route('inventario.vista.todas') }}" class="g_boton g_boton_light">
                Inicio <i class="fa-solid fa-house"></i></a>
        </div>
    </div>

    <!--TABLA-->
    <div class="g_panel">
        @if ($inventarios->count())
        <!--TABLA CABECERA-->
        <div class="tabla_cabecera">
            <!--TABLA CABECERA BOTONES-->
            <div class="tabla_cabecera_botones">
                <button>
                    PDF <i class="fa-solid fa-file-pdf"></i>
                </button>

                <button>
                    EXCEL <i class="fa-regular fa-file-excel"></i>
                </button>
            </div>

            <!--TABLA CABECERA BUSCAR-->
            <div class="tabla_cabecera_buscar">
                <form action="">
                    <input type="text" wire:model.live.debounce.1300ms="buscarProducto" id="buscarProducto" name="buscarProducto" placeholder="Buscar...">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </form>
            </div>
        </div>

        <!--TABLA CONTENIDO-->
        <div class="tabla_contenido g_margin_bottom_20">
            <div class="contenedor_tabla">
                <table class="tabla">
                    <thead>
                        <tr>
                            <th>Nº</th>
                            <th>Producto</th>
                            <th>Medida</th>
                            <th>Stock</th>
                            <th>Última actualización</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($inventarios as $inventario)
                        <tr>
                            <td class="g_resaltar"> {{ $loop->iteration }} </td>
                            <td class="g_resaltar">ID: {{ $inventario->producto->id }}-{{ $inventario->producto->nombre }}</td>
                            <td class="g_resaltar">{{ $inventario->producto->unidadMedida->nombre ?? 'Sin unidad' }}</td>
                            <td class="g_resaltar">{{ number_format($inventario->stock, 2) }} </td>
                            <td class="g_inferior g_resumir"> {{ $inventario->updated_at->format('d/m/Y H:i') }} </td>
                            <td class="centrar_iconos">
                                <a href="#" class="g_accion_editar">
                                    <span><i class="fa-solid fa-pencil"></i></span>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @if ($inventarios->hasPages())
        <div>
            {{ $inventarios->onEachSide(1)->links() }}
        </div>
        @endif
        @else
        <div class="g_vacio">
            <p>No hay elementos.</p>
            <i class="fa-regular fa-face-grin-wink"></i>
        </div>
        @endif
    </div>
</div>
