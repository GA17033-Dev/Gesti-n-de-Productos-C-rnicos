<?php
namespace App\Models;

use App\Models\BaseModel;

class Producto extends BaseModel
{
    protected $table = 'productos';
    protected $fillable = [
        'id_categoria',
        'nombre',
        'descripcion',
        'precio',
        'stock',
        'estado',
        'created_at',
        'updated_at'
    ];
    protected $hidden = [];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria');
    }
    //detalleVentas\
    public function detalleVentas()
    {
        return $this->hasMany(DetalleVenta::class, 'id_producto');
    }
}