<?php

require_once __DIR__ . '/../vendor/autoload.php';

$router = new \Bramus\Router\Router();

require_once __DIR__ . '/../routes/web.php';

$router->run();