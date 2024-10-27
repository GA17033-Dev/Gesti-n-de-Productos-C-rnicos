<?php
namespace App\Controllers;
use App\Lib\Controller;
use App\Lib\Response;
use App\Models\User;

class UserController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $users = User::all();
        return $this->render('users/index', ['users' => $users]);
    }
    //profile 
    public function profile()
    {
        $user = User::find($_SESSION['user_id']);
      echo $user;
        //return $this->render('users/profile', ['user' => $user]);
    }
}