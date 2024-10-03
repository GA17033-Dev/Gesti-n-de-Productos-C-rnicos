<?php

namespace App\Lib;

class Functions
{
    public static  function encryptPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public static function response($data, $status = 200)
    {
        http_response_code($status);
        echo json_encode($data);
    }
}
