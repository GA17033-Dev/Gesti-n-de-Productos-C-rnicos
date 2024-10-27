<?php

namespace App\Models;

use App\Models\BaseModel;

class Categoria extends BaseModel 
{
    protected $table = 'categorias';
    protected $fillable = [
        'nombre',
        'descripcion',
        'created_at',
        'updated_at'
    ];

    public function productos()
    {
        return $this->hasMany(Producto::class, 'id_categoria', 'id');
    }
}