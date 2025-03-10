<div>
    <!--CABECERA TITULO PAGINA-->
    <div class="g_panel cabecera_titulo_pagina">
        <!--TITULO-->
        <h2>Productos</h2>

        <!--BOTONES-->
        <div class="cabecera_titulo_botones">
            <a href="#" class="g_boton g_boton_light">
                Inicio <i class="fa-solid fa-house"></i></a>

            <a href="#" class="g_boton g_boton_primary">
                Crear <i class="fa-solid fa-square-plus"></i></a>
        </div>
    </div>

    @if (session()->has('message'))
    <div class="bg-green-100 text-green-700 p-2 rounded">
        {{ session('message') }}
    </div>
    @endif

    <button wire:click="crear()" class="bg-blue-500 text-white px-4 py-2 rounded">Nuevo Producto</button>

    <table class="w-full mt-4 border">
        <thead>
            <tr class="bg-gray-100">
                <th class="border px-4 py-2">ID</th>
                <th class="border px-4 py-2">Nombre</th>
                <th class="border px-4 py-2">Unidad Base</th>
                <th class="border px-4 py-2">Precio Compra</th> <!-- Nuevo campo -->
                <th class="border px-4 py-2">precio Venta</th> <!-- Nuevo campo -->
                <th class="border px-4 py-2">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($productos as $producto)
            <tr>
                <td class="border px-4 py-2">{{ $producto->id }}</td>
                <td class="border px-4 py-2">{{ $producto->nombre }}</td>
                <td class="border px-4 py-2">{{ $producto->unidadMedida?->nombre }}</td>
                <td class="border px-4 py-2">{{ number_format($producto->precio_compra, 2) }}</td> <!-- Mostrar precio_venta -->
                <td class="border px-4 py-2">{{ number_format($producto->precio_venta, 2) }}</td> <!-- Mostrar precio_venta -->
                <td class="border px-4 py-2">
                    <button wire:click="editar({{ $producto->id }})" class="bg-yellow-500 text-white px-2 py-1 rounded">Editar</button>
                    <button wire:click="eliminar({{ $producto->id }})" class="bg-red-500 text-white px-2 py-1 rounded">Eliminar</button>
                </td>
            </tr>
            @endforeach
        </tbody>

    </table>

    @if ($modal)
    <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white p-6 rounded">
            <h2 class="text-lg font-bold">{{ $producto_id ? 'Editar Producto' : 'Nuevo Producto' }}</h2>

            <input type="text" wire:model="nombre" placeholder="Nombre" class="w-full border p-2 mt-2">
            @error('nombre') <span class="text-red-500">{{ $message }}</span> @enderror

            <select wire:model="unidad_medida_id" class="w-full border p-2 mt-2">
                <option value="">Seleccione una unidad</option>
                @foreach($unidades as $unidad)
                <option value="{{ $unidad->id }}">{{ $unidad->nombre }}</option>
                @endforeach
            </select>
            @error('unidad_medida_id') <span class="text-red-500">{{ $message }}</span> @enderror

            <input type="number" wire:model="precio_compra" placeholder="precio_compra" class="w-full border p-2 mt-2">
            @error('precio_compra') <span class="text-red-500">{{ $message }}</span> @enderror

            <input type="number" wire:model="precio_venta" placeholder="precio_venta" class="w-full border p-2 mt-2">
            @error('precio_venta') <span class="text-red-500">{{ $message }}</span> @enderror


            <div class="mt-4">
                <button wire:click="guardar()" class="bg-blue-500 text-white px-4 py-2 rounded">Guardar</button>
                <button wire:click="cerrarModal()" class="bg-gray-500 text-white px-4 py-2 rounded">Cerrar</button>
            </div>
        </div>
    </div>
    @endif
</div>
