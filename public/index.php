<?php

// Iniciar la sesión
session_start();

// Configuración de errores para desarrollo
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Autoload de Composer
require_once __DIR__ . '/../vendor/autoload.php';

// Cargar variables de entorno
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Inicializar el router
$router = new \Bramus\Router\Router();

// Cargar las rutas
require_once __DIR__ . '/../routes/web.php';

// Ejecutar el router
$router->run();

