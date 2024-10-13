<?php
namespace App\Controllers;

use App\Lib\Controller;

class VentaController extends Controller
{
    public function index()
    {
        return $this->render('ventas/ventas');
    }
}