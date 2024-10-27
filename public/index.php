<?php

require_once __DIR__ . '/../vendor/autoload.php';

$router = new \Bramus\Router\Router();
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');

require_once __DIR__ . '/../routes/web.php';

$dotenv->load();

$router->run();