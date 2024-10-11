<?php
use App\Controllers\HomeController;

$router->get('/', 'App\Controllers\HomeController@index');
$router->post('/store', 'App\Controllers\HomeController@store');
//login
 $router->post('/login', 'App\Controllers\HomeController@login');
 //register
$router->get('/register', 'App\Controllers\HomeController@register');
//register/user

$router->post('/register/user', 'App\Controllers\HomeController@registerUser');
//dashboard
$router->get('/dashboard', 'App\Controllers\HomeController@dashboard');
//index users
$router->get('/usuarios', 'App\Controllers\UserController@index');
//prdouctos
$router->get('/productos', 'App\Controllers\ProductoController@index');
//roles
$router->get('/roles', 'App\Controllers\RolController@index');
//roles/add
$router->post('/roles/add', 'App\Controllers\RolController@store');
//put /roles/edit/id
$router->post('/roles/edit', 'App\Controllers\RolController@updateRol');
///roles/delete
$router->post('/roles/delete', 'App\Controllers\RolController@deleteRol');
///roles/recover
$router->post('/roles/recover', 'App\Controllers\RolController@recoverRol');
//categorias
$router->get('/categorias', 'App\Controllers\CategoriaController@index');
///categorias/store
$router->post('/categorias/store', 'App\Controllers\CategoriaController@store');
//categorias/update
$router->post('/categorias/update', 'App\Controllers\CategoriaController@updateCategoria');
///productos/store
$router->post('/productos/store', 'App\Controllers\ProductoController@store');
///productos/update
$router->post('/productos/update', 'App\Controllers\ProductoController@updateProducto');
///productos/delete
$router->post('/productos/delete', 'App\Controllers\ProductoController@deleteProducto');
//exportar
$router->post('/exportar', 'App\Controllers\ProductoController@exportar');

