<?php
spl_autoload_register(function ($class) {
    echo "Trying to load: $class<br>";
});
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../vendor/autoload.php';

$router = new \Bramus\Router\Router();
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

require_once __DIR__ . '/../routes/web.php';

$router->run();
