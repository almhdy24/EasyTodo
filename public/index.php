<?php

require_once __DIR__ . "/../vendor/autoload.php";

use EasyTodo\Controllers\TaskController;
use EasyTodo\Controllers\AuthController;
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
$router->addRoute("GET", "/", function () {
  require "../src/Views/home.php";
});

$router->addRoute("GET", "/tasks", function () {
  $controller = new TaskController();
  $controller->index();
});

$router->addRoute("POST", "/tasks", function () {
  $controller = new TaskController();
  $controller->create($_POST);
});

$router->addRoute("GET", "/tasks/create", function () {
  $controller = new TaskController();
  $controller->createForm();
});

$router->addRoute("POST", "/tasks/create", function () {
  $controller = new TaskController();
  $controller->create($_POST);
});

// Add delete route
$router->addRoute("POST", "/tasks/delete/(\d+)", function ($id) {
  $controller = new TaskController();
  $controller->delete($id);
});

// Authentication routes
$router->addRoute("GET", "/login", function () {
  $controller = new AuthController();
  $controller->showLoginForm();
});

$router->addRoute("POST", "/login", function () {
  $controller = new AuthController();
  $controller->login($_POST);
});

$router->addRoute("GET", "/register", function () {
  $controller = new AuthController();
  $controller->showRegisterForm();
});

$router->addRoute("POST", "/register", function () {
  $controller = new AuthController();
  $controller->register($_POST);
});

$router->addRoute("GET", "/logout", function () {
  $controller = new AuthController();
  $controller->logout();
});

// Dispatch the request
$router->dispatch($_SERVER["REQUEST_METHOD"], $_SERVER["REQUEST_URI"]);
