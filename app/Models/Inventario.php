<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    /** @use HasFactory<\Database\Factories\InventarioFactory> */
    use HasFactory;

    protected $fillable = ['producto_id', 'stock'];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
