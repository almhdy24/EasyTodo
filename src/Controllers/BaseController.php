<?php 
namespace EasyTodo\Controllers;

class BaseController {
    protected function render($view, $data = []) {
        extract($data);
        include dirname(__DIR__) . '/Views/' . $view . '.php';
    }
}