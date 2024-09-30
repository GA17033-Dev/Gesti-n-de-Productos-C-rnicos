<?php

namespace App\Lib;

class View
{
    private array $d;


    public function render(string $name, array $data = [])
    {
        $this->d = $data;
        require_once __DIR__ . '/../views/' . $name . '.php';
    }
}
