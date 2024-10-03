<?php
namespace App\Models;

use App\Models\BaseModel;

class RolesUsuario extends BaseModel
{
    protected $table = 'roles_usuarios';
    protected $fillable = [
        'id',
        'id_usuario',
        'id_rol',
        'created_at',
        'updated_at'
    ];
    protected $hidden = [];
}