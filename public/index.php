<?php

require_once __DIR__ . "/../vendor/autoload.php";

use EasyTodo\Controllers\TaskController;
use EasyTodo\Controllers\PasswordResetController;
use EasyTodo\Controllers\UserController;
use EasyTodo\Config\Database;
use EasyTodo\Router;
use Dotenv\Dotenv;

session_start();

// Load environment variables
$dotenv = Dotenv::createImmutable(__DIR__ . "/../src/Config/");
$dotenv->load();

// Initialize the database
Database::init();

// Initialize the router
$router = new Router();

// Define routes
$router->addRoute('GET', '/', function() {
    require '../src/Views/home.php';
});

$router->addRoute('GET', '/tasks', function() {
    $controller = new TaskController();
    $controller->index();
});

$router->addRoute('POST', '/tasks', function() {
    $controller = new TaskController();
    $controller->create($_POST);
});

$router->addRoute('GET', '/tasks/create', function() {
    $controller = new TaskController();
    $controller->createForm();
});

$router->addRoute('POST', '/tasks/create', function() {
    $controller = new TaskController();
    $controller->create($_POST);
});

$router->addRoute('POST', '/password/reset', function() {
    $controller = new PasswordResetController();
    $controller->requestReset($_POST["email"]);
});

$router->addRoute('POST', '/password/reset/confirm', function() {
    $controller = new PasswordResetController();
    $controller->reset($_POST["token"], $_POST["password"]);
});

$router->addRoute('GET', '/login', function() {
    $controller = new UserController();
    $controller->loginForm();
});

$router->addRoute('POST', '/login', function() {
    $controller = new UserController();
    $controller->login($_POST);
});

$router->addRoute('GET', '/register', function() {
    $controller = new UserController();
    $controller->registerForm();
});

$router->addRoute('POST', '/register', function() {
    $controller = new UserController();
    $controller->register($_POST);
});

// Dispatch the request
$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);