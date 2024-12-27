<?php

namespace EasyTodo\Controllers;

use EasyTodo\Models\User;

class AuthController extends BaseController
{
  public function showLoginForm()
  {
    
    $this->render("auth/login");
  }

  public function login($data)
  {
    
    $user = new User();
    if ($user->login($data["email"], $data["password"])) {
      header("Location: /tasks");
    } else {
      $_SESSION["error"] = "Invalid email or password.";
      header("Location: /login");
    }
    exit();
  }

  public function showRegisterForm()
  {
    
    $this->render("auth/register");
  }

  public function register($data)
  {
    
    $user = new User();
    if ($user->register($data["name"], $data["email"], $data["password"])) {
      $_SESSION["success"] = "Registration successful. Please login.";
      header("Location: /login");
    } else {
      $_SESSION["error"] = "Registration failed. Please try again.";
      header("Location: /register");
    }
    exit();
  }

  public function logout()
  {
    
    session_destroy();
    header("Location: /login");
    exit();
  }
}
