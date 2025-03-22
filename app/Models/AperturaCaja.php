<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AperturaCaja extends Model
{
    /** @use HasFactory<\Database\Factories\AperturaCajaFactory> */
    use HasFactory;

    protected $table = 'apertura_cajas';

    protected $fillable = [
        'fecha',
        'hora_apertura',
        'monto_inicial',
        'estado',
        'hora_cierre',
        'monto_final',
    ];

    protected $casts = [
        'fecha' => 'date',
        'hora_apertura' => 'datetime:H:i:s',
        'hora_cierre' => 'datetime:H:i:s',
        'monto_inicial' => 'decimal:2',
        'monto_final' => 'decimal:2',
    ];

    public function cierreCaja()
    {
        return $this->hasOne(CierreCaja::class, 'apertura_caja_id');
    }
}
