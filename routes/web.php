<?php

use App\Controllers\HomeController;
use App\Controllers\UserController;
use App\Controllers\ProductoController;
use App\Controllers\RolController;
use App\Controllers\CategoriaController;
use App\Controllers\VentaController;
use App\Middleware\AuthMiddleware;

$authMiddleware = function () {
    AuthMiddleware::handle();
};

// Rutas públicas
$router->get('/', 'App\Controllers\HomeController@index');
$router->post('/store', 'App\Controllers\HomeController@store');
// $router->match('GET|POST', '/login', 'App\Controllers\HomeController@login');
$router->get('/register', 'App\Controllers\HomeController@register');
$router->post('/register/user', 'App\Controllers\HomeController@registerUser');

$router->before('GET|POST', '/dashboard.*', $authMiddleware);
$router->before('GET|POST', '/usuarios.*', $authMiddleware);
$router->before('GET|POST', '/productos.*', $authMiddleware);
$router->before('GET|POST', '/roles.*', $authMiddleware);
$router->before('GET|POST', '/categorias.*', $authMiddleware);
$router->before('GET|POST', '/ventas.*', $authMiddleware);
$router->before('POST', '/exportar', $authMiddleware);

$router->get('/dashboard', 'App\Controllers\HomeController@dashboard');
$router->get('/usuarios', 'App\Controllers\UserController@index');
$router->get('/productos', 'App\Controllers\ProductoController@index');
$router->get('/roles', 'App\Controllers\RolController@index');
$router->post('/roles/add', 'App\Controllers\RolController@store');
$router->post('/roles/edit', 'App\Controllers\RolController@updateRol');
$router->post('/roles/delete', 'App\Controllers\RolController@deleteRol');
$router->post('/roles/recover', 'App\Controllers\RolController@recoverRol');
$router->get('/categorias', 'App\Controllers\CategoriaController@index');
$router->post('/categorias/store', 'App\Controllers\CategoriaController@store');
$router->post('/categorias/update', 'App\Controllers\CategoriaController@updateCategoria');
$router->post('/productos/store', 'App\Controllers\ProductoController@store');
$router->post('/productos/update', 'App\Controllers\ProductoController@updateProducto');
$router->post('/productos/delete', 'App\Controllers\ProductoController@deleteProducto');
$router->post('/exportar', 'App\Controllers\ProductoController@exportar');
$router->get('/ventas', 'App\Controllers\VentaController@index');
$router->post('/productos/buscar', 'App\Controllers\ProductoController@buscar');
//profile
$router->get('/profile', 'App\Controllers\UserController@profile');
$router->post('/profile/update', 'App\Controllers\UserController@updateProfile');
///obtener_totales
$router->get('/obtener_totales', 'App\Controllers\HomeController@obtenerTotales');
$router->get('/logout', 'App\Controllers\HomeController@logout');
//login
$router->post('/login', 'App\Controllers\HomeController@login');

//ventas/store
$router->post('/ventas/store', 'App\Controllers\VentaController@store');
//portada
$router->get('/portada', 'App\Controllers\HomeController@portada');
