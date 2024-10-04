<?php

namespace App\Controllers;

use App\Models\User;
use App\Lib\Controller;
use App\Lib\Functions;

class HomeController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {

        // $user = User::with('roles', 'ventas')->find(1);
        // if ($user) {
        //     return Functions::response($user);
        // }
        // return Functions::response("Usuario no encontrado", 404);
        //crear un usuario

        $data = [
            'nombre' => 'admin',
            'email' => 'admin5@admin.com',
            'apellido' => 'admin1',
            'password' => Functions::encryptPassword('admin'),
            'username' => 'admin5',
            'telefono' => '123456789',
            'direccion' => 'admin',
            'estado' => 1,
            'email_verified_at' => date('Y-m-d H:i:s'),
        ];

        $user = new User($data);
        $user->save();
        $user->roles()->attach(1);
        return Functions::response($user, 201);
    }


    public function store()
    {
        $data = [
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'password' => Functions::encryptPassword($_POST['password'])
        ];

        $user = new User($data);
        $user->save();
        echo 'User created';
    }


    //respoder a una solicitud

}
