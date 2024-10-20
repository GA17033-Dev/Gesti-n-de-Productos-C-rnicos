<?php

namespace App\Controllers;

use App\Models\RolesUsuario;
use App\Models\User;
use App\Lib\Controller;
use App\Lib\Functions;
use App\Services\AuthService;
use App\Lib\Response;

class HomeController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        if (isset($_SESSION['user_id'])) {
            header('Location: /dashboard');
            exit();
        }

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
    }


    // public function login()
    // {
    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         $email = $_POST['email'] ?? '';
    //         $password = $_POST['password'] ?? '';

    //         if (Functions::attempt($email, $password)) {
    //             return Response::json([
    //                 'success' => true,
    //                 'message' => 'Bienvenido'
    //             ])->send();
    //         } else {
    //             return Response::json([
    //                 'success' => false,
    //                 'message' => 'Credenciales inválidas'
    //             ], 401)->send();
    //         }
    //     }

    //     return $this->render('login');
    // }
    public function login()
    {
        if (isset($_SESSION['user_id'])) {
            header('Location: /dashboard');
            exit();
        }


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            if (Functions::attempt($email, $password)) {
                $user = User::where('email', $email)->first();
                $_SESSION['user_id'] = $user->id;
                $_SESSION['user_email'] = $user->email;

                // header('Location: /dashboard');
                // exit();
                return Response::json([
                    'success' => true,
                    'message' => 'Bienvenido'
                ])->send();
            } else {
                return Response::json([
                    'success' => false,
                    'message' => 'Credenciales inválidas'
                ], 401)->send();
            }
        }

        return $this->render('login');
    }

    public function logout()
    {
        session_destroy();
        header('Location: /');
        exit();
    }

    //register
    public function register()
    {
        if (isset($_SESSION['user_id'])) {
            header('Location: /dashboard');
            exit();
        }
        return $this->render('register');
    }
    //registerUser
    public function registerUser()
    {
        try {
            User::beginTransaction();

            $data = [
                'nombre' => $_POST['first_name'],
                'apellido' => $_POST['last_name'],
                'email' => $_POST['email'],
                'password' => Functions::encryptPassword($_POST['password']),
                'username' => Functions::generateUsername($_POST['first_name'], $_POST['last_name']),
                'estado' => 1,
                'telefono' => $_POST['phone'],
                'direccion' => $_POST['address']
            ];

            // Verificar si el usuario ya existe
            $existingUser = User::where('email', $data['email'])->first();
            if ($existingUser) {
                User::rollBack();
                return Response::json([
                    'success' => false,
                    'message' => 'El usuario ya existe',
                    'user' => $existingUser
                ], 401)->send();
            }

            $user = new User($data);
            if (!$user->save()) {
                User::rollBack();
                return Response::json([
                    'success' => false,
                    'message' => 'No se pudo guardar el usuario',
                ], 500)->send();
            }

            $bringUser = User::where('email', $data['email'])->first();

            if (!$bringUser) {
                User::rollBack();
                return Response::json([
                    'success' => false,
                    'message' => 'No se pudo obtener el ID del usuario'
                ], 500)->send();
            }


            // Agregar rol
            $data_role = [
                'id_usuario' => $bringUser->id,
                'id_rol' => 2
            ];
            $usuario_role = new RolesUsuario($data_role);
            if (!$usuario_role->save()) {
                User::rollBack();
                return Response::json([
                    'success' => false,
                    'message' => 'No se pudo asignar el rol al usuario'
                ], 500)->send();
            }

            User::commit();

            return Response::json([
                'success' => true,
                'message' => 'Usuario registrado correctamente'
            ])->send();
        } catch (\Exception $e) {
            User::rollBack();
            return Response::json([
                'success' => false,
                'message' => 'Error al registrar el usuario: ' . $e->getMessage()
            ], 500)->send();
        } catch (\Error $e) {
            User::rollBack();
            return Response::json([
                'success' => false,
                'message' => 'Error crítico al registrar el usuario: ' . $e->getMessage()
            ], 500)->send();
        }
    }

    // public function dashboard()
    // {
    //     $users = User::all();


    //     return $this->render('admin/dashboard/index', [
    //         'users' => $users
    //     ]);
    // }

    public function dashboard()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }
        $users = User::all();

        return $this->render('admin/dashboard/index', ['users' => $users]);
    }
}
