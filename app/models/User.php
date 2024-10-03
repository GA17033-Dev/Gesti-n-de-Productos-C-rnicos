<?php

namespace App\Models;

use App\Models\BaseModel;

class User extends BaseModel
{
    protected $table = 'users';
    protected $fillable = ['name', 'email', 'password'];
    protected $hidden = ['password'];

    public function setPassword($password)
    {
        $this->attributes['password'] = password_hash($password, PASSWORD_DEFAULT);
    }

    public function verifyPassword($password)
    {
        return password_verify($password, $this->password);
    }

    public function updatePassword($password)
    {
        $this->setPassword($password);
        return $this->update();
    }
}