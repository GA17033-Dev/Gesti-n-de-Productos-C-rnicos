<?php

namespace App\Controllers;

use App\Models\User;
use App\Lib\Controller;

class HomeController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {

        $user = new User();
        $users = $user->all();
        echo json_encode($users);
        
    }

    //encriptar contraseña
    public function encryptPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function store()
    {
        $data = [
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'password' => $this->encryptPassword($_POST['password'])
        ];

        $user = new User($data);
        $user->save();
        echo 'User created';
    }
    
    
}
