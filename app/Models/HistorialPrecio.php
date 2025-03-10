<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialPrecio extends Model
{
    /** @use HasFactory<\Database\Factories\HistorialPrecioFactory> */
    use HasFactory;

    protected $fillable = ['producto_id', 'precio_compra', 'precio_venta', 'fecha'];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
