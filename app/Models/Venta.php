<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    /** @use HasFactory<\Database\Factories\VentaFactory> */
    use HasFactory;

    protected $fillable = ['fecha'];

    public function detalleVentas()
    {
        return $this->hasMany(DetalleVenta::class);
    }
}
