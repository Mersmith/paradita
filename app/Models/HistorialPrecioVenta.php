<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialPrecioVenta extends Model
{
    /** @use HasFactory<\Database\Factories\HistorialPrecioVentaFactory> */
    use HasFactory;

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
