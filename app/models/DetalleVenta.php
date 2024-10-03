<?php
namespace App\Models;

use App\Models\BaseModel;

class DetalleVenta extends BaseModel
{
    protected $table = 'detalle_ventas';
    protected $fillable = [
        'id',
        'id_venta',
        'id_producto',
        'cantidad',
        'precio',
        'subtotal',
        'created_at',
        'updated_at'
    ];
    protected $hidden = [];
}