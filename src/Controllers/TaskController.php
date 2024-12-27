<?php
namespace EasyTodo\Controllers;

use EasyTodo\Models\Task;

class TaskController extends BaseController
{
  public function __construct() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }
    }
  public function index()
  {
    $tasks = Task::getAll();
    $this->render("tasks/index", ["tasks" => $tasks]);
  }

  public function create($data)
  {
    $task = new Task($data);
    $task->save();
    header("Location: /tasks");
  }

  public function createForm()
  {
    $this->render("tasks/create");
  }
  // Add the delete method
  public function delete($id)
  {
    $task = new Task();
    $task->delete($id);

    // Redirect back to the tasks index page
    header("Location: /tasks");
    exit();
  }
}
