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
        $user = User::all();
        if ($user) {
            // Esto devolverá automáticamente un array con los datos del usuario
            return Functions::response($user);
        } else {
            return Functions::response("Usuario no encontrado", 404);
        }
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
