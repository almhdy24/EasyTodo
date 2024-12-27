<?php

namespace EasyTodo\Controllers;

use EasyTodo\Models\User;

class AuthController {
    public function showLoginForm() {
        require '../src/Views/auth/login.php';
    }

    public function login($data) {
        $user = new User();
        if ($user->login($data['email'], $data['password'])) {
            header('Location: /tasks');
        } else {
            header('Location: /login?error=invalid_credentials');
        }
        exit();
    }

    public function showRegisterForm() {
        require '../src/Views/auth/register.php';
    }

    public function register($data) {
        $user = new User();
        if ($user->register($data['name'], $data['email'], $data['password'])) {
            header('Location: /login?success=registered');
        } else {
            header('Location: /register?error=registration_failed');
        }
        exit();
    }

    public function logout() {
        session_destroy();
        header('Location: /login');
        exit();
    }
}