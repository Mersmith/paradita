<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialPrecioCompra extends Model
{
    /** @use HasFactory<\Database\Factories\HistorialPrecioCompraFactory> */
    use HasFactory;

    protected $fillable = ['producto_id', 'precio_unitario', 'cantidad', 'fecha'];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
