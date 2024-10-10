<?php

namespace App\Lib;

class View
{
    protected static $blocks = [];
    protected static $layout = null;

    public static function render($view, $data = [])
    {
        extract($data);
        
        ob_start();
        include self::getViewPath($view);
        $content = ob_get_clean();

        if (static::$layout) {
            include self::getViewPath(static::$layout);
        } else {
            echo $content;
        }

        static::$layout = null;
        static::$blocks = [];
    }

    protected static function getViewPath($view)
    {
        return __DIR__ . '/../../resources/views/' . $view . '.php';
    }

    public static function extends($layout)
    {
        static::$layout = $layout;
    }

    public static function section($name)
    {
        ob_start();
    }

    public static function endSection($name)
    {
        static::$blocks[$name] = ob_get_clean();
    }

    public static function yield($name)
    {
        echo static::$blocks[$name] ?? '';
    }

    public static function addData($key, $value)
    {
        $$key = $value;
    }
}