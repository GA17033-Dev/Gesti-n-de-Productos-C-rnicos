<?php

namespace App\Services;

use App\Models\User;

class AuthService
{
    public function attempt($email, $password)
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
}
