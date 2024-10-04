<?php

namespace App\Models;

use App\Models\BaseModel;

class Categoria extends BaseModel
{
    protected $table = 'categorias';
    protected $fillable = [
        'id',
        'nombre',
        'descripcion',
        'created_at',
        'updated_at'
    ];
    protected $hidden = [];

    public function productos()
    {
        return $this->hasMany(Producto::class, 'id_categoria');
    }
}