<?php

namespace App\Lib;

use App\Models\User;

class Controller
{
    private View $view;

    public function __construct()
    {
        $this->view = new View();
    }

    // public function render(string $name, array $data = [])
    // {
    //     $this->view->render($name, $data);
    // }

    protected function render($view, $data = [])
    {
        // Añadir información del usuario logueado a todas las vistas
        if (isset($_SESSION['user_id'])) {
            $user = User::find($_SESSION['user_id']);
            $data['loggedInUser'] = $user;
        }

        // Tu lógica existente para renderizar la vista
        View::render($view, $data);
    }
    public function post(string $param)
    {
        if (!isset($_POST[$param])) {
            return NULL;
        }
        return $_POST[$param];
    }

    public function get(string $param)
    {
        if (!isset($_GET[$param])) {
            return NULL;
        }
        return $_GET[$param];
    }

    //redirect
    public function redirect(string $url, $data = [])
    {
        foreach ($data as $key => $value) {

            $this->view->addData($key, $value);
        }

        header("Location: $url");
    }
}
