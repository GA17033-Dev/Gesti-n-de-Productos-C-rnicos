<?php
namespace App\Models;

class Venta extends BaseModel
{
    protected $table = 'ventas';
    protected $fillable = [
        'numero_venta',
        'fecha',
        'total',
        'id_usuario',
        'estado',
        'descuento',
        'total_final',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    public function detalleVenta()
    {
        return $this->hasMany(DetalleVenta::class, 'id_venta');
    }

    
}
