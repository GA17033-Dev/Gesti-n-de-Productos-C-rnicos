<?php
namespace App\Controllers;

use App\Lib\Controller;
use App\Models\Categoria;
use App\Lib\Response;

class CategoriaController extends Controller
{
    
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $categorias = Categoria::all();
        return $this->render('categorias/index', ['categorias' => $categorias]);
    }
    //store
    public function store()
    {
        try {
            $data = [
                'nombre' => $_POST['nombre'],
                'descripcion' => $_POST['descripcion']
            ];
            $categoria = new Categoria($data);
            $categoria->save();
            return Response::json([
                'success' => true,
                'message' => 'Categoria creada correctamente'
            ])->send();
        } catch (\Exception $e) {
            return Response::json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500)->send();
        }
    }
    //updateCategoria
    public function updateCategoria()
    {
        try {
            $data = [
                'id' => intval($_POST['id']),
                'nombre' => $_POST['nombre'],
                'descripcion' => $_POST['descripcion']
            ];

            $categoria = Categoria::find($data['id']);
            if (!$categoria) {
                throw new \Exception("Categoria no encontrada");
            }

            $categoria->fill($data);
            $categoria->save();
            return Response::json([
                'success' => true,
                'message' => 'Categoria actualizada correctamente'
            ])->send();
        } catch (\Exception $e) {
            return Response::json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500)->send();
        }
    }

    public function deleteCategoria()
{
    try {
        $id = $_POST['id']; 
        $categoria = Categoria::find($id);
        
        if (!$categoria) {
            return Response::json([
                'success' => false,
                'message' => 'Categoría no encontrada'
            ], 404)->send();
        }
        
    
        $categoria->delete();
        
        return Response::json([
            'success' => true,
            'message' => 'Categoría eliminada correctamente'
        ])->send();
    } catch (\Exception $e) {
        return Response::json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500)->send();
    }
}


}