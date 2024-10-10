<?php
namespace App\Controllers;

use App\Lib\Controller;
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
        return $this->render('productos/index', ['productos' => $productos]);
    }
}