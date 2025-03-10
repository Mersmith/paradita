<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    /** @use HasFactory<\Database\Factories\ProductoFactory> */
    use HasFactory;

    protected $fillable = ['nombre', 'unidad_medida_id', 'precio_compra', 'precio_venta'];

    public function inventario()
    {
        return $this->hasOne(Inventario::class);
    }

    public function detalleCompras()
    {
        return $this->hasMany(DetalleCompra::class);
    }

    public function detalleVentas()
    {
        return $this->hasMany(DetalleVenta::class);
    }

    public function historialPrecios()
    {
        return $this->hasMany(HistorialPrecio::class);
    }

    public function historialPrecioCompras()
    {
        return $this->hasMany(HistorialPrecioCompra::class);
    }

    public function historialPrecioVentas()
    {
        return $this->hasMany(HistorialPrecioVenta::class);
    }

    public function unidadMedida()
    {
        return $this->belongsTo(UnidadMedida::class, 'unidad_medida_id');
    }
}
