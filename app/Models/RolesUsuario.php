<?php
namespace App\Models;

class RolesUsuario extends BaseModel
{
    protected $table = 'roles_usuarios';
    protected $fillable = [
        'id_usuario',
        'id_rol'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'id_rol');
    }
}