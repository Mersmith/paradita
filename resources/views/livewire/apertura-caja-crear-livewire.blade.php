<div>
    <!--CABECERA TITULO PAGINA-->
    <div class="g_panel cabecera_titulo_pagina">
        <!--TITULO-->
        <h2>Apertura caja</h2>

        <!--BOTONES-->
        <div class="cabecera_titulo_botones">
            <a href="{{ route('apertura-caja.vista.todas') }}" class="g_boton g_boton_light">
                Inicio <i class="fa-solid fa-house"></i></a>

                <a href="{{ route('apertura-caja.vista.todas') }}" class="g_boton g_boton_darkt">
                    <i class="fa-solid fa-arrow-left"></i> Regresar</a>
        </div>
    </div>

    <div class="g_panel">

        @if (!$aperturaHoy)
        <div>
            <label>Monto Inicial:</label>
            <input type="number" step="0.01" wire:model="monto_inicial">
            <button wire:click="abrirCaja" class="g_boton g_boton_primary">Abrir Caja</button>
        </div>
        @else
        <div>
            <p>Fecha: {{ $aperturaHoy->fecha }}</p>
            <p>Hora Apertura: {{ $aperturaHoy->hora_apertura }}</p>

            <p>Monto Inicial:
                @if ($editando_monto_inicial)
                <input type="number" step="0.01" wire:model="monto_inicial">
                <button wire:click="guardarMontoInicial">Guardar</button>
                @else
                S/ {{ number_format($aperturaHoy->monto_inicial, 2) }}
                <button wire:click="editarMontoInicial">Editar</button>
                @endif
            </p>

            <p>Estado: <strong>{{ strtoupper($aperturaHoy->estado) }}</strong></p>

            @if ($aperturaHoy->estado == 'abierta')
            <div>
                <p>Monto Final:
                    @if ($editando_monto_final)
                    <input type="number" step="0.01" wire:model="monto_final">
                    <button wire:click="guardarMontoFinal">Guardar</button>
                    @else
                    S/ {{ number_format($monto_final, 2) }}
                    <button wire:click="editarMontoFinal">Editar</button>
                    @endif
                </p>
                <button wire:click="cerrarCaja" class="g_boton g_boton_danger">Cerrar Caja</button>
            </div>
            @else
            <p>Hora Cierre: {{ $aperturaHoy->hora_cierre }}</p>
            <p>Monto Final: S/ {{ number_format($aperturaHoy->monto_final, 2) }}</p>
            @endif
        </div>
        @endif
    </div>
</div>
