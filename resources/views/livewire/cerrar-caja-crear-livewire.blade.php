@section('tituloPagina', 'Cerrar Caja')

<div>
    <div class="g_panel cabecera_titulo_pagina">
        <h2>Cerrar Caja - {{ $aperturaCaja->fecha }}</h2>
        <div class="cabecera_titulo_botones">
            <a href="#" class="g_boton g_boton_light">Inicio <i class="fa-solid fa-house"></i></a>
            <a href="#" class="g_boton g_boton_dark"><i class="fa-solid fa-arrow-left"></i> Regresar</a>
        </div>
    </div>

    @if (session()->has('success'))
    <div class="g_alerta g_alerta_exito">{{ session('success') }}</div>
    @endif

    @if ($aperturaCaja->cierreCaja)
    <div class="g_panel">
        <h4 class="g_panel_titulo">Detalles del Cierre</h4>
        <p><strong>Fecha de Cierre:</strong> {{ $aperturaCaja->cierreCaja->fecha_cierre }}</p>
        <p><strong>Monto Contado:</strong> S/ {{ number_format($aperturaCaja->cierreCaja->monto_contado, 2) }}</p>
        <p><strong>Diferencia:</strong> S/ {{ number_format($aperturaCaja->cierreCaja->diferencia, 2) }}</p>
        <p><strong>Observaciones:</strong> {{ $aperturaCaja->cierreCaja->observaciones }}</p>
    </div>
    @else

    <div class="formulario">
        <form wire:submit.prevent="cerrarCaja">
            <div class="g_fila">
                <div class="g_columna_6">
                    <div class="g_panel">
                        <h4 class="g_panel_titulo">Billetes</h4>
                        @foreach($billetes as $billete)
                        <div class="g_margin_bottom_20">
                            <label>Billetes de S/ {{ $billete['valor'] }}</label>
                            <input type="number" wire:model.live="{{ $billete['nombre'] }}">
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="g_columna_6">
                    <div class="g_panel">
                        <h4 class="g_panel_titulo">Monedas</h4>
                        @foreach($monedas as $moneda)
                        <div class="g_margin_bottom_20">
                            <label>Monedas de S/ {{ $moneda['valor'] }}</label>
                            <input type="number" wire:model.live="{{ $moneda['nombre'] }}">
                        </div>
                        @endforeach
                    </div>
                </div>


            </div>

            <div class="g_fila">
                <div class="g_columna_6">
                    <label>Pago con Tarjeta</label>
                    <input type="number" wire:model.live="monto_tarjeta">

                    <label>Pago con Billetera Digital</label>
                    <input type="number" wire:model.live="monto_billetera_digital">
                </div>

                <div class="g_columna_6">
                    <h3>Total: S/ {{ number_format($monto_total, 2) }}</h3>
                </div>
            </div>
            <button type="submit" class="g_boton g_boton_primary" @if ($aperturaCaja->cierreCaja) disabled @endif>
                Cerrar Caja
            </button>
        </form>
    </div>
    @endif
</div>
