<?php
use App\Controllers\HomeController;

$router->get('/', 'App\Controllers\HomeController@index');
$router->post('/store', 'App\Controllers\HomeController@store');
//login
$router->post('/login', 'App\Controllers\HomeController@login');