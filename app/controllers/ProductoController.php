<?php

namespace App\Controllers;

use App\Lib\Controller;
use App\Lib\Response;
use App\Models\Categoria;
use App\Models\Producto;

class ProductoController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $productos = Producto::all(); 

        foreach ($productos as &$producto) {
            $categoria = Categoria::find($producto['id_categoria']);
            if (!$categoria) {
                error_log("Categoría no encontrada para id: " . $producto['id_categoria']);
                $producto['categoria'] = null;
            } else {
                $producto['categoria'] = $categoria->toArray();
            }
        }
        $categorias = Categoria::all();
        return $this->render('productos/index', ['productos' => $productos, 'categorias' => $categorias]);
    }

    //store
    public function store()
    {
        try {
            $data = [
                'id_categoria' => intval($_POST['categoria']),
                'nombre' => $_POST['nombre'],
                'descripcion' => $_POST['descripcion'],
                'precio' => $_POST['precio'],
                'stock' => $_POST['stock'],
                'estado' => 1
            ];
            $producto = new Producto($data);
            $producto->save();
            return Response::json([
                'success' => true,
                'message' => 'Producto creado correctamente'
            ])->send();
        } catch (\Exception $e) {
            return Response::json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500)->send();
        }
    }
}
