<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\UnidadMedidaLivewire;
use App\Livewire\ProductoLivewire;
use App\Livewire\CompraCrearLivewire;
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
Route::get('/producto', ProductoLivewire::class)->name('producto.vista.todas');//ok
Route::get('/compra-crear', CompraCrearLivewire::class)->name('compra-crear.vista.todas');//ok
Route::get('/venta-crear', VentaCrearLivewire::class)->name('venta-crear.vista.todas');//ok
