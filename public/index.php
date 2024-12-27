<?php

ob_start(); // Start output buffering

require_once __DIR__ . "/../vendor/autoload.php";

use EasyTodo\Controllers\TaskController;
use EasyTodo\Controllers\AuthController;
use EasyTodo\Controllers\PasswordResetController;
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

$router->addRoute('POST', '/tasks/delete/(\d+)', function($id) {
    $controller = new TaskController();
    $controller->delete($id);
});

// Authentication routes
$router->addRoute('GET', '/login', function() {
    $controller = new AuthController();
    $controller->showLoginForm();
});

$router->addRoute('POST', '/login', function() {
    $controller = new AuthController();
    $controller->login($_POST);
});

$router->addRoute('GET', '/register', function() {
    $controller = new AuthController();
    $controller->showRegisterForm();
});

$router->addRoute('POST', '/register', function() {
    $controller = new AuthController();
    $controller->register($_POST);
});

$router->addRoute('POST', '/logout', function() {
    $controller = new AuthController();
    $controller->logout();
});

// Password reset routes
$router->addRoute('GET', '/password/request', function() {
    $controller = new PasswordResetController();
    $controller->requestResetForm();
});

$router->addRoute('POST', '/password/request', function() {
    $controller = new PasswordResetController();
    $controller->handleRequestReset($_POST);
});

$router->addRoute('GET', '/password/reset', function() {
    $controller = new PasswordResetController();
    $controller->resetPasswordForm($_GET['token']);
});

$router->addRoute('POST', '/password/reset', function() {
    $controller = new PasswordResetController();
    $controller->handleResetPassword($_POST);
});

// Dispatch the request
$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);

ob_end_flush(); // Send the buffered output to the browser