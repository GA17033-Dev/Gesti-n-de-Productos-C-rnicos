<?php
namespace App\Controllers;
use App\Models\User;
use App\Lib\Controller;

class HomeController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        
        $user = new User();
        $users = $user->all();
         echo json_encode($users);
    }
}