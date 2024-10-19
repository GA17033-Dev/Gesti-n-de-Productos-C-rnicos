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

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    public function detalleVenta()
    {
        return $this->hasMany(DetalleVenta::class, 'id_venta');
    }

    
}
