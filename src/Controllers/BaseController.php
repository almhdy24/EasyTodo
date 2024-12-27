<?php 
namespace EasyTodo\Controllers;

class BaseController {
    protected function render($view, $data = []) {
        extract($data);
        include __DIR__ . '/../Views/' . $view . '.php';
    }
}