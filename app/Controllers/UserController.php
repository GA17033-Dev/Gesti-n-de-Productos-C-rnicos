<?php

namespace App\Controllers;

use App\Lib\Controller;
use App\Lib\Response;
use App\Models\Rol;
use App\Models\RolesUsuario;
use App\Models\User;
use App\Models\Venta;

class UserController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $users = User::all();
        $roles = Rol::all();

        foreach ($users as &$user) {
            $user['rol'] = null;
            $rol = RolesUsuario::where('id_usuario', $user['id'])->first();
            if ($rol) {

                $user['rol'] = Rol::find($rol->id_rol);
            }
        }
        unset($user);
        //return Response::json($roles)->send();

        return $this->render('users/index', ['users' => $users, 'roles' => $roles]);
    }
    //profile 
    public function profile()
    {
        $user = User::find($_SESSION['user_id']);


        $ventas = Venta::where('id_usuario', $_SESSION['user_id'])->get();
        $totalVentas = 0;

        foreach ($ventas as $venta) {
            $totalVentas++;
        }

        return $this->render('users/profile', ['user' => $user, 'totalVentas' => $totalVentas]);
    }
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
    public function updateSecurity()
    {
        try {
            $user = User::find($_SESSION['user_id']);
            if (!password_verify($_POST['current_password'], $user->password)) {
                return Response::json([
                    'success' => false,
                    'message' => 'Contraseña incorrecta'
                ], 400)->send();
            }
            $user->password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
            $user->save();

            return Response::json([
                'success' => true,
                'message' => 'Contraseña actualizada'
            ])->send();
        } catch (\Exception $e) {
            return Response::json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500)->send();
        }
    }
    //update
    public function update()
    {
        try {
            $user = User::find($_POST['id']);
            $email = User::where('email', $_POST['email'])->first();
            if ($email && $email->id != $user->id) {
                return Response::json([
                    'success' => false,
                    'message' => 'El email ya existe'
                ], 400)->send();
            }
            $user->username = $_POST['username'];
            $user->email = $_POST['email'];
            $user->nombre = $_POST['nombre'];
            $user->apellido = $_POST['apellido'];
            $user->direccion = $_POST['direccion'];
            $user->telefono = $_POST['telefono'];
            $user->save();

            $rol = RolesUsuario::where('id_usuario', $user->id)->first();
            if ($rol) {
                $rol->id_rol = $_POST['rol'];
                $rol->save();
            } else {
                $rol = new RolesUsuario([
                    'id_usuario' => $user->id,
                    'id_rol' => $_POST['rol']
                ]);
                $rol->save();
            }
            return Response::json([
                'success' => true,
                'message' => 'Usuario actualizado'
            ])->send();
        } catch (\Exception $e) {
            return Response::json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500)->send();
        }
    }
    //delete
    
}
