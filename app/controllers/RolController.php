<?php

namespace App\Controllers;

use App\Lib\Controller;
use App\Models\RolesUsuario;
use App\Models\User;
use App\Lib\Functions;
use App\Lib\Response;
use App\Models\Rol;

class RolController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $roles = Rol::all();
        return $this->render('roles/index', ['roles' => $roles]);
    }
    public function store()
    {
        try {
            $data = [
                'nombre' => $_POST['nombre'],
                'descripcion' => $_POST['descripcion']
            ];
            $rol = new Rol($data);
            $rol->save();
            return Response::json([
                'success' => true,
                'message' => 'Rol creado correctamente'
            ])->send();
        } catch (\Exception $e) {
            return Response::json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500)->send();
        }
    }
}
