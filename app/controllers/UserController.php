<?php
namespace App\Controllers;
use App\Lib\Controller;
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
}