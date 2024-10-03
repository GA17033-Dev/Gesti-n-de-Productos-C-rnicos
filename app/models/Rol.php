<?php
namespace App\Models;

use App\Models\BaseModel;

class Rol extends BaseModel
{
    protected $table = 'roles';
    protected $fillable = [
        'id',
        'nombre',
        'descripcion',
        'estado',
        'created_at',
        'updated_at'
    ];
    protected $hidden = [];
}