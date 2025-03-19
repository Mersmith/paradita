<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\UnidadMedidaLivewire;
use App\Livewire\UnidadMedidaCrearLivewire;
use App\Livewire\UnidadMedidaEditarLivewire;
use App\Livewire\ProductoLivewire;
use App\Livewire\ProductoCrearLivewire;
use App\Livewire\ProductoEditarLivewire;
use App\Livewire\InventarioLivewire;
use App\Livewire\CompraLivewire;
use App\Livewire\CompraDetalleLivewire;
use App\Livewire\CompraDetalleEditarLivewire;
use App\Livewire\CompraCrearLivewire;
use App\Livewire\VentaLivewire;
use App\Livewire\VentaCrearLivewire;

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('/', UnidadMedidaLivewire::class)->name('unidad-medida.vista.todas');//ok
Route::get('/unidad-medida/crear', UnidadMedidaCrearLivewire::class)->name('unidad-medida.vista.crear');//ok
Route::get('/unidad-medida/editar/{id}', UnidadMedidaEditarLivewire::class)->name('unidad-medida.vista.editar');//ok

Route::get('/producto', ProductoLivewire::class)->name('producto.vista.todas');//ok
Route::get('/producto/crear', ProductoCrearLivewire::class)->name('producto.vista.crear');//ok
Route::get('/producto/editar/{id}', ProductoEditarLivewire::class)->name('producto.vista.editar');//ok

Route::get('/inventario', InventarioLivewire::class)->name('inventario.vista.todas');//ok

Route::get('/compra', CompraLivewire::class)->name('compra.vista.todas');//ok
Route::get('/compra-crear', CompraCrearLivewire::class)->name('compra-crear.vista.crear');//ok
Route::get('/compra/{id}/detalle', CompraDetalleLivewire::class)->name('compra-detalle.vista.ver');//ok
Route::get('/compra/editar/{id}/detalle', CompraDetalleEditarLivewire::class)->name('compra-detalle.vista.editar');//ok

Route::get('/venta', VentaLivewire::class)->name('venta.vista.todas');//ok
Route::get('/venta-crear', VentaCrearLivewire::class)->name('venta-crear.vista.crear');//ok
