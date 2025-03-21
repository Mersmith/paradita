<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    /** @use HasFactory<\Database\Factories\CompraFactory> */
    use HasFactory;

    protected $fillable = ['fecha', 'estado'];

    public function detalleCompras()
    {
        return $this->hasMany(DetalleCompra::class);
    }
}
