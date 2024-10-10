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

    //update
    public function updateRol()
    {
        try {
            $data = [
                'id' => intval($_POST['id']),
                'nombre' => $_POST['nombre'],
                'descripcion' => $_POST['descripcion']
            ];

            $rol = Rol::find($data['id']);
            if (!$rol) {
                throw new \Exception("Rol no encontrado");
            }

            $rol->fill($data);
            if ($rol->save()) {
                return Response::json([
                    'success' => true,
                    'message' => 'Rol actualizado con éxito'
                ])->send();
            } else {
                throw new \Exception("No se pudo actualizar el rol");
            }
        } catch (\Exception $e) {
            return Response::json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500)->send();
        }
    }
    public function deleteRol()
    {
        try {
            $data = [
                'id' => intval($_POST['id'])
            ];

            $rol = Rol::find($data['id']);
            $rol->estado = 0;
            if (!$rol) {
                throw new \Exception("Rol no encontrado");
            }

            if ($rol->save()) {
                return Response::json([
                    'success' => true,
                    'message' => 'Rol eliminado con éxito'
                ])->send();
            } else {
                throw new \Exception("No se pudo eliminar el rol");
            }
        } catch (\Exception $e) {
            return Response::json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500)->send();
        }
    }
    public function recoverRol()
    {
        try {
            $data = [
                'id' => intval($_POST['id'])
            ];

            $rol = Rol::find($data['id']);
            $rol->estado = 1;
            if (!$rol) {
                throw new \Exception("Rol no encontrado");
            }

            if ($rol->save()) {
                return Response::json([
                    'success' => true,
                    'message' => 'Rol recuperado con éxito'
                ])->send();
            } else {
                throw new \Exception("No se pudo recuperar el rol");
            }
        } catch (\Exception $e) {
            return Response::json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500)->send();
        }
    }
}
