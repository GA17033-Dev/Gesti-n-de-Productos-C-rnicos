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

//        $data = [
//            'nombre' => 'admin',
//            'email' => 'admin6@admin.com',
//            'apellido' => 'admin1',
//            'password' => Functions::encryptPassword('admin'),
//            'username' => 'admin6',
//            'telefono' => '123456789',
//            'direccion' => 'admin',
//            'estado' => 1,
//            'email_verified_at' => date('Y-m-d H:i:s'),
//        ];
//        //validar antes que no exista
//        $user = User::where('email', $data['email'])->first();
//
//        if ($user) {
//            return Functions::response("Usuario ya existe", 400);
//        }
//
//
//
//        $user = new User($data);
//        $user->save();
//
//        //asignar rol
//        $user->roles()->attach(1);
//
//        return Functions::response($user, 201);
        //retornar vista de login
        return $this->render('login');
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


    ///login
    //recibir datos
    public function login()
    {
        $email = $this->post('email');
        $password = $this->post('password');

        if (!$email || !$password) {
            return Functions::response("Datos incompletos", 400);
        }

        //buscar usuario
        $user = User::where('email', $email)->first();

        if (!$user) {
            return Functions::response("Usuario no encontrado", 404);
        }

        //verificar contraseña
        // if (!Functions::verifyPassword($password, $user->password)) {
        //     return Functions::response("Contraseña incorrecta", 400);
        // }

        // //generar token
        // $token = Functions::generateToken($user->id);

        // return Functions::response($token);
    }

}
