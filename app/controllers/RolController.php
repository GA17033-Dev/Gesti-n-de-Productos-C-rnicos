<?php
namespace App\Controllers;

use App\Lib\Controller;
use App\Models\RolesUsuario;
use App\Models\User;
use App\Lib\Functions;
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

   
}