@section('tituloPagina', 'Detalle de Compra')

@section('anchoPantalla', '100%')

<div>
    <!-- CABECERA -->
    <div class="g_panel cabecera_titulo_pagina">
        <h2>Detalle de Compra</h2>
        <div class="cabecera_titulo_botones">
            <a href="#" class="g_boton g_boton_light">
                Volver <i class="fa-solid fa-arrow-left"></i>
            </a>
        </div>
    </div>

    <!-- INFORMACIÓN GENERAL -->
    <div class="g_panel">
        <h4 class="g_panel_titulo">Información General</h4>
        <p><strong>Fecha:</strong> {{ $compra->fecha }}</p>
        <p><strong>Total de Productos:</strong> {{ count($detalles) }}</p>
    </div>

    <!-- TABLA DE DETALLES -->
    <div class="g_panel">
        <h4 class="g_panel_titulo">Detalles de la Compra</h4>
        <div class="tabla_contenido">
            <div class="contenedor_tabla">
                <table class="tabla">
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>Producto</th>
                            <th>Unidad</th>
                            <th>Cantidad</th>
                            <th>Precio Compra</th>
                            <th>Subtotal Compra</th>
                            <th>Precio Venta</th>
                            <th>Subtotal Venta</th>
                            <th>Margen de Ganancia</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($detalles as $index => $detalle)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $detalle->producto->nombre }}</td>
                            <td>{{ $detalle->unidadMedida->nombre }}</td>
                            <td>{{ number_format($detalle->cantidad, 2) }}</td>
                            <td>{{ number_format($detalle->precio_unitario, 2) }}</td>
                            <td>{{ number_format($detalle->cantidad * $detalle->precio_unitario, 2) }}</td>
                            <td>{{ number_format($detalle->producto->precio_venta, 2) }}</td>
                            <td>{{ number_format($detalle->cantidad * $detalle->producto->precio_venta, 2) }}</td>
                            <td>
                                <strong>
                                    {{ number_format(($detalle->producto->precio_venta - $detalle->precio_unitario) * $detalle->cantidad, 2) }}
                                </strong>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                    <tfoot>
                        <tr>
                            <td colspan="5"><strong>Total</strong></td>
                            <td><strong>{{ number_format($detalles->sum(fn($d) => $d->cantidad * $d->precio_unitario), 2) }}</strong></td>
                            <td></td>
                            <td><strong>{{ number_format($detalles->sum(fn($d) => $d->cantidad * $d->producto->precio_venta), 2) }}</strong></td>
                            <td><strong>{{ number_format($detalles->sum(fn($d) => ($d->producto->precio_venta - $d->precio_unitario) * $d->cantidad), 2) }}</strong></td>
                        </tr>
                    </tfoot>

                </table>
            </div>
        </div>
    </div>
</div>
