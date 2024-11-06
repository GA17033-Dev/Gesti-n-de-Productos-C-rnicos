<?php

namespace App\Controllers;


use App\Models\RolesUsuario;
use App\Models\User;
use App\Lib\Controller;
use App\Lib\Functions;
use App\Services\AuthService;
use App\Lib\Response;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Venta;
use App\Lib\View;
use App\Models\DetalleVenta;
use Exception;

class HomeController extends Controller
{
    public function obtenerProductos()
    {
        return Producto::all();
    }

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
    // Controlador
    // public function obtenerTotales()
    // {
    //     try {
    //         // Obtener los totales de registros activos
    //         $totalProductos = Producto::where('estado', 1)->count(); // Filtrar solo productos activos
    //         $totalUsuarios = User::where('estado', 1)->count(); // Filtrar solo usuarios activos
    //         $totalVentas = Venta::count(); // Ajusta esto según si las ventas tienen un estado o no

    //         // Devolver los datos en formato JSON
    //         return Response::json([
    //             'totalProductos' => $totalProductos,
    //             'totalUsuarios' => $totalUsuarios,
    //             'totalVentas' => $totalVentas,
    //         ])->send();
    //     } catch (Exception $e) { // Captura de excepciones
    //         return Response::json(['error' => 'Error al obtener totales: ' . $e->getMessage()], 500)->send();
    //     }
    // }
    public function obtenerTotales()
    {
        try {
            // Totales básicos
            $totalProductos = Producto::where('estado', 1)->get();
            $totalProductosCount = count($totalProductos);

            $totalUsuarios = User::where('estado', 1)->get();
            $totalUsuariosCount = count($totalUsuarios);

            $totalVentas = Venta::where('estado', 1)->get();
            $totalVentasCount = count($totalVentas);

            // Ventas por categoría
            $categorias = Categoria::all();
            $ventasPorCategoria = [];

            foreach ($categorias as $categoria) {
                $total = 0;
                $productos = Producto::where('id_categoria', '=', $categoria['id'])->get();

                foreach ($productos as $producto) {
                    $detallesVenta = DetalleVenta::where('id_producto', '=', $producto['id'])->get();
                    foreach ($detallesVenta as $detalle) {
                        $total += floatval($detalle['subtotal']);
                    }
                }

                if ($total > 0) {
                    $ventasPorCategoria[] = [
                        'nombre' => $categoria['nombre'],
                        'total' => $total
                    ];
                }
            }

            // Ventas mensuales
            $ventasMensuales = [];
            $año_actual = date('Y');
            $ventas = Venta::where('estado', '=', 1)->get();

            foreach ($ventas as $venta) {
                if (!empty($venta['fecha'])) {
                    $fecha_venta = strtotime($venta['fecha']);
                    $mes = date('n', $fecha_venta);
                    $año = date('Y', $fecha_venta);

                    if ($año == $año_actual) {
                        if (!isset($ventasMensuales[$mes])) {
                            $ventasMensuales[$mes] = [
                                'mes' => $mes,
                                'total' => 0,
                                'monto' => 0
                            ];
                        }
                        $ventasMensuales[$mes]['total']++;
                        $ventasMensuales[$mes]['monto'] += floatval($venta['total_final']);
                    }
                }
            }

            // Convertir a array indexado y ordenar por mes
            $ventasMensuales = array_values($ventasMensuales);
            usort($ventasMensuales, function ($a, $b) {
                return $a['mes'] - $b['mes'];
            });

            // Productos más vendidos
            $productos = Producto::all();
            $productosMasVendidos = [];

            foreach ($productos as $producto) {
                $totalVendido = 0;
                $detallesVenta = DetalleVenta::where('id_producto', '=', $producto['id'])->get();

                foreach ($detallesVenta as $detalle) {
                    $totalVendido += intval($detalle['cantidad']);
                }

                if ($totalVendido > 0) {
                    $productosMasVendidos[] = [
                        'nombre' => $producto['nombre'],
                        'total_vendido' => $totalVendido
                    ];
                }
            }

            // Ordenar productos más vendidos y tomar los 5 primeros
            usort($productosMasVendidos, function ($a, $b) {
                return $b['total_vendido'] - $a['total_vendido'];
            });
            $productosMasVendidos = array_slice($productosMasVendidos, 0, 5);

            // Calcular monto total de ventas
            $montoTotalVentas = 0;
            foreach ($ventas as $venta) {
                if ($venta['estado'] == 1) {
                    $montoTotalVentas += floatval($venta['total_final']);
                }
            }

            // Calcular promedio de venta diaria
            $ventasHoy = array_filter($ventas, function ($venta) {
                return !empty($venta['fecha']) &&
                    $venta['fecha'] == date('Y-m-d') &&
                    $venta['estado'] == 1;
            });

            $promedioVentaDiaria = 0;
            if (count($ventasHoy) > 0) {
                $totalHoy = array_sum(array_map(function ($venta) {
                    return floatval($venta['total_final']);
                }, $ventasHoy));
                $promedioVentaDiaria = $totalHoy / count($ventasHoy);
            }

            // Ventas última semana
            $fechaUltimaSemana = date('Y-m-d', strtotime('-7 days'));
            $ventasUltimaSemana = array_filter($ventas, function ($venta) use ($fechaUltimaSemana) {
                return !empty($venta['fecha']) &&
                    $venta['fecha'] >= $fechaUltimaSemana &&
                    $venta['estado'] == 1;
            });
            $totalVentasUltimaSemana = count($ventasUltimaSemana);

            return Response::json([
                'success' => true,
                'data' => [
                    'totalProductos' => $totalProductosCount,
                    'totalUsuarios' => $totalUsuariosCount,
                    'totalVentas' => $totalVentasCount,
                    'ventasPorCategoria' => $ventasPorCategoria,
                    'ventasMensuales' => $ventasMensuales,
                    'productosMasVendidos' => $productosMasVendidos,
                    'montoTotalVentas' => $montoTotalVentas,
                    'promedioVentaDiaria' => number_format($promedioVentaDiaria, 2),
                    'ventasUltimaSemana' => $totalVentasUltimaSemana
                ]
            ])->send();
        } catch (Exception $e) {
            return Response::json([
                'success' => false,
                'message' => 'Error al obtener totales: ' . $e->getMessage()
            ], 500)->send();
        }
    }


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
                //header('Location: /dashboard');
                //exit();
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
    public function dashboard()
    {
        // Obtener los datos necesarios para el dashboard
        $productos = $this->obtenerProductos(); // Obtener productos
        $categorias = $this->obtenerCategorias(); // Obtener categorías

        // Pasar los datos a la vista
        View::render('dashboard/index', compact('productos', 'categorias'));
    }
    // Método para obtener categorías
    public function obtenerCategorias()
    {
        return Categoria::all(); // Ajusta según tu implementación
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
}
