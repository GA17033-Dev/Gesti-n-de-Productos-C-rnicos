<?php

namespace App\Models;

class User extends BaseModel
{
    protected $table = 'users';
    protected $fillable = [
        'name', 'email', 'password', 'username', 'telefono', 'direccion', 'estado', 'email_verified_at'
    ];
    protected $hidden = ['password'];

    public function roles()
    {
        return $this->belongsToMany(Rol::class, 'roles_usuarios', 'id_usuario', 'id_rol');
    }
    //ventas
    public function ventas()
    {
        return $this->hasMany(Venta::class, 'id_usuario');
    }
}