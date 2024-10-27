<?php

namespace App\Lib;

use App\Models\User;

class Functions
{
    public static  function encryptPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public static function decryptPassword($password, $hash)
    {
        return password_verify($password, $hash);
    }

    public static function response($data = [], $status = 200)
    {
        http_response_code($status);
        echo json_encode($data);
        exit;
    }

    public static function attempt($email, $password)
    {
        $user = User::where('email', $email);
        if ($user && password_verify($password, $user->password)) {
            $_SESSION['user_id'] = $user->id;
            return true;
        }
        return false;
    }

    public function check()
    {
        return isset($_SESSION['user_id']);
    }

    public function user()
    {
        if ($this->check()) {
            return User::find($_SESSION['user_id']);
        }
        return null;
    }

    public function logout()
    {
        unset($_SESSION['user_id']);
        session_destroy();
    }
    public static function generateUsername($name, $lastName)
    {
       // return strtolower(substr($name, 0, 1) . $lastName); agregar un numero aleatorio
         return strtolower(substr($name, 0, 1) . $lastName . rand(0, 100));

    }
}
