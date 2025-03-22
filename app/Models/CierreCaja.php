<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CierreCaja extends Model
{
    /** @use HasFactory<\Database\Factories\CierreCajaFactory> */
    use HasFactory;

    protected $table = 'cierre_cajas';

    protected $fillable = [
        'apertura_caja_id',
        'fecha_cierre',
        'billete_200',
        'billete_100',
        'billete_50',
        'billete_20',
        'billete_10',
        'moneda_5',
        'moneda_2',
        'moneda_1',
        'moneda_50',
        'moneda_20',
        'moneda_10',
        'monto_tarjeta',
        'monto_billetera_digital',
        'monto_efectivo',
        'monto_calculado',
        'monto_contado',
        'diferencia',
        'observaciones',
    ];

    /**
     * Relación inversa con AperturaCaja (Cada cierre pertenece a una apertura)
     */
    public function aperturaCaja()
    {
        return $this->belongsTo(AperturaCaja::class, 'apertura_caja_id');
    }
}
