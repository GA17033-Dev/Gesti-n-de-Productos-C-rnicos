<?php

namespace App\Controllers;

use App\Models\RolesUsuario;
use App\Models\User;
use App\Lib\Controller;
use App\Lib\Functions;
use App\Services\AuthService;
use App\Lib\Response;
use App\Models\Producto;
use App\Models\Venta;
use App\Models\Categoria;
use App\Lib\View;
use Exception; // Asegúrate de importar Exception

class HomeController extends Controller
{
    public function obtenerProductos() {
        return Producto::all(); 
    }

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        return $this->render('login');
    }

    public function dashboard() {
        // Obtener los datos necesarios para el dashboard
        $productos = $this->obtenerProductos(); // Obtener productos
        $categorias = $this->obtenerCategorias(); // Obtener categorías
        
        // Pasar los datos a la vista
        View::render('dashboard/index', compact('productos', 'categorias'));
    }

    // Método para obtener categorías
    public function obtenerCategorias() {
        return Categoria::all(); // Ajusta según tu implementación
    }

    // Controlador
    public function obtenerTotales()
{
    try {
        // Obtener los totales de registros activos
        $totalProductos = Producto::where('estado', 1)->count(); // Filtrar solo productos activos
        $totalUsuarios = User::where('estado', 1)->count(); // Filtrar solo usuarios activos
        $totalVentas = Venta::count(); // Ajusta esto según si las ventas tienen un estado o no

        // Devolver los datos en formato JSON
        return Response::json([
            'totalProductos' => $totalProductos,
            'totalUsuarios' => $totalUsuarios,
            'totalVentas' => $totalVentas,
        ])->send();
    } catch (Exception $e) { // Captura de excepciones
        return Response::json(['error' => 'Error al obtener totales: ' . $e->getMessage()], 500)->send();
    }
}

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            if (Functions::attempt($email, $password)) {
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

    //register
    public function register()
    {
        return $this->render('register');
    }

    //registerUser
    public function registerUser()
    {
        try {
            // Iniciar una transacción de base de datos
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
            $existingUser = User::where('email', $data['email']);
            if ($existingUser) {
                User::rollBack();
                return Response::json([
                    'success' => false,
                    'message' => 'El usuario ya existe'
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

            $bringUser = User::where('email', $data['email']);
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

            // Si todo salió bien, confirmar la transacción
            User::commit();

            return Response::json([
                'success' => true,
                'message' => 'Usuario registrado correctamente'
            ])->send();
        } catch (\Exception $e) { // Captura de excepciones
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
}