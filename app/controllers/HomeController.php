<?php
namespace App\Controllers;
use App\Models\User;

class HomeController
{
    public function index()
    {
        
        $user = new User();
        $users = $user->all();
         echo json_encode($users);
    }
}