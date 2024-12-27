<?php
namespace EasyTodo\Controllers;

use EasyTodo\Models\Task;

class TaskController extends BaseController {
    public function index() {
        $tasks = Task::getAll();
        var_dump($tasks); // Add this line to check the fetched tasks
        $this->render('tasks/index', ['tasks' => $tasks]);
    }

    public function create($data) {
        $task = new Task($data);
        $task->save();
        header('Location: /tasks');
    }

    public function createForm() {
        $this->render('tasks/create');
    }
}
