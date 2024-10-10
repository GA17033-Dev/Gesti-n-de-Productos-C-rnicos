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
