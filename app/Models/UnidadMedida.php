<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnidadMedida extends Model
{
    /** @use HasFactory<\Database\Factories\UnidadMedidaFactory> */
    use HasFactory;

    protected $fillable = ['nombre'];
}
