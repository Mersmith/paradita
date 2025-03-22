@section('tituloPagina', 'Aperturas de Caja')

@section('anchoPantalla', '100%')

<div>
    <!--CABECERA TITULO PAGINA-->
    <div class="g_panel cabecera_titulo_pagina">
        <h2>Aperturas de Caja</h2>

        <div class="cabecera_titulo_botones">
            <a href="{{ route('apertura-caja.vista.todas') }}" class="g_boton g_boton_light">
                Inicio <i class="fa-solid fa-house"></i></a>

            <a href="{{ route('apertura-caja-crear.vista.crear') }}" class="g_boton g_boton_primary">
                Crear <i class="fa-solid fa-square-plus"></i></a>
        </div>
    </div>

    <!--FORMULARIO FILTROS-->
    <div class="formulario">
        <div class="g_fila">
            <div class="g_columna_12">
                <div class="g_panel">
                    <div class="g_fila">
                        <div class="g_columna_6">
                            <div class="tabla_cabecera_filtros">
                                <label for="fechaInicio">Desde:</label>
                                <input type="date" wire:model.live="fechaInicio" id="fechaInicio">
                            </div>
                        </div>

                        <div class="g_columna_6">
                            <div class="tabla_cabecera_filtros">
                                <label for="fechaFin">Hasta:</label>
                                <input type="date" wire:model.live="fechaFin" id="fechaFin">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--TABLA LISTADO DE CAJAS-->
    <div class="g_panel">
        @if ($cajas->count())
        <div class="tabla_cabecera">
            <div class="tabla_cabecera_botones">
                <button>PDF <i class="fa-solid fa-file-pdf"></i></button>
                <button>EXCEL <i class="fa-regular fa-file-excel"></i></button>
            </div>

            <div class="tabla_cabecera_buscar">
                <form action="">
                    <input type="text" wire:model.live.debounce.1300ms="buscarCaja" id="buscarCaja" name="buscarCaja" placeholder="Buscar...">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </form>
            </div>
        </div>

        <div class="tabla_contenido g_margin_bottom_20">
            <div class="contenedor_tabla">
                <table class="tabla">
                    <thead>
                        <tr>
                            <th>Nº</th>
                            <th>Fecha</th>
                            <th>Monto Inicial</th>
                            <th>Monto Final</th>
                            <th>Estado Apertura</th>
                            <th>Estado Cierre</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cajas as $item)
                        <tr>
                            <td class="g_resaltar"> {{ $loop->iteration }} </td>
                            <td class="g_resaltar">{{ $item->fecha }}</td>
                            <td>S/ {{ number_format($item->monto_inicial, 2) }}</td>
                            <td>S/ {{ number_format($item->monto_final ?? 0, 2) }}</td>
                            <td>
                                <span class="g_estado_{{ $item->estado == 'abierta' ? 'activo' : 'inactivo' }}">
                                    {{ ucfirst($item->estado) }}
                                </span>
                            </td>

                            <td>
                                @if ($item->cierreCaja)
                                <a href="{{ route('cerrar-caja-crear.vista.crear', ['id' => $item->id]) }}" class="g_boton g_boton_info">
                                    Ver Cierre <i class="fa-solid fa-plus"></i>
                                </a>
                                S/ {{ number_format($item->cierreCaja->monto_contado, 2) }}
                                @else
                                <a href="{{ route('cerrar-caja-crear.vista.crear', ['id' => $item->id]) }}" class="g_boton g_boton_info">
                                    Crear Cierre <i class="fa-solid fa-plus"></i>
                                </a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @if ($cajas->hasPages())
        <div>
            {{ $cajas->onEachSide(1)->links() }}
        </div>
        @endif
        @else
        <div class="g_vacio">
            <p>No hay aperturas de caja registradas.</p>
            <i class="fa-regular fa-face-grin-wink"></i>
        </div>
        @endif
    </div>
</div>
