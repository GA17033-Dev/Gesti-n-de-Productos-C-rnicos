<?php

namespace App\Controllers;

use App\Lib\Controller;
use App\Lib\Response;
use App\Models\User;

class UserController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $users = User::all();
        return $this->render('users/index', ['users' => $users]);
    }
    //profile 
    public function profile()
    {
        $user = User::find($_SESSION['user_id']);

        return $this->render('users/profile', ['user' => $user]);
    }
    //updateProfile
    public function updateProfile()
    {
        try {
            $user = User::find($_SESSION['user_id']);
            $email = User::where('email', $_POST['email'])->first();
            if ($email && $email->id != $user->id) {
                return Response::json([
                    'success' => false,
                    'message' => 'El email ya existe'
                ], 400)->send();
            }
            $user->username = $_POST['username'];
            $user->email = $_POST['email'];
            $user->nombre = $_POST['first_name'];
            $user->apellido = $_POST['last_name'];
            $user->direccion = $_POST['address'];
            $user->telefono = $_POST['telefono'];
            $user->save();

            return Response::json([
                'success' => true,
                'message' => 'Perfil actualizado'
            ])->send();
        } catch (\Exception $e) {
            return Response::json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500)->send();
        }
    }
}
