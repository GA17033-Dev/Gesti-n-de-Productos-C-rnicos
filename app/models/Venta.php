<?php
namespace App\Models;

use App\Models\BaseModel;

class Venta extends BaseModel
{
    protected $table = 'ventas';
    protected $fillable = [
        'id',
        'numero_venta',
        'fecha',
        'total',
        'id_usuario',
        'estado',
        'descuento',
        'total_final',
        'created_at',
        'updated_at'
    ];
    protected $hidden = [];
}
