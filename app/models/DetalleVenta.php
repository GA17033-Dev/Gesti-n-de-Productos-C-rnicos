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

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }

    public function venta()
    {
        return $this->belongsTo(Venta::class, 'id_venta');
    }

    
}