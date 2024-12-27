<?php

require_once __DIR__ . "/../vendor/autoload.php";

use EasyTodo\Controllers\TaskController;
use EasyTodo\Controllers\PasswordResetController;
use EasyTodo\Controllers\UserController;
use EasyTodo\Config\Database;
use Dotenv\Dotenv;

session_start();

// Load environment variables
$dotenv = Dotenv::createImmutable(__DIR__ . "/../src/Config/");
$dotenv->load();

// Initialize the database
Database::init();

// Get the request URI and method
$requestUri = $_SERVER["REQUEST_URI"];
$requestMethod = $_SERVER["REQUEST_METHOD"];

// Basic routing mechanism
switch ($requestUri) {
  case "/":
  case "/tasks":
    $controller = new TaskController();
    if ($requestMethod === "GET") {
      $controller->index();
    } elseif ($requestMethod === "POST") {
      $controller->create($_POST);
    }
    break;

  case "/tasks/create":
    $controller = new TaskController();
    if ($requestMethod === "GET") {
      $controller->createForm();
    } elseif ($requestMethod === "POST") {
      $controller->create($_POST);
    }
    break;

  case "/password/reset":
    $controller = new PasswordResetController();
    if ($requestMethod === "POST") {
      $controller->requestReset($_POST["email"]);
    }
    break;

  case "/password/reset/confirm":
    $controller = new PasswordResetController();
    if ($requestMethod === "POST") {
      $controller->reset($_POST["token"], $_POST["password"]);
    }
    break;

  case "/login":
    $controller = new UserController();
    if ($requestMethod === "GET") {
      $controller->loginForm();
    } elseif ($requestMethod === "POST") {
      $controller->login($_POST);
    }
    break;

  case "/register":
    $controller = new UserController();
    if ($requestMethod === "GET") {
      $controller->registerForm();
    } elseif ($requestMethod === "POST") {
      $controller->register($_POST);
    }
    break;

  default:
    http_response_code(404);
    echo "Page not found";
    break;
}
