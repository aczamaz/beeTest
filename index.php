<?php
require('vendor/autoload.php');

define('BASEPATH','/App/Views/');

$router = new \Bramus\Router\Router();
$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$router->get('/', "App\Controllers\TableController@index");

$router->get('/login/', "App\Controllers\UserController@login");

$router->post('/login/', "App\Controllers\UserController@loginUser");
$router->get('/logout/', "App\Controllers\UserController@logout");

$router->get('/add-task/', "App\Controllers\TableController@addTaskForm");
$router->post('/add-task/', "App\Controllers\TableController@addTask");
$router->get('/done-task/(\d+)/', "App\Controllers\TableController@done");
$router->get('/edit-task/(\d+)/', "App\Controllers\TableController@editTaskForm");
$router->POST('/edit-task/(\d+)/', "App\Controllers\TableController@editTask");

$router->run();