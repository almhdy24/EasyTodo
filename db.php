<?php
class Database {
    private $db;

    public function __construct($dbFile) {
        $this->db = new SQLite3($dbFile);
    }

    public function deleteTodoById($id) {
        $stmt = $this->db->prepare('DELETE FROM todos WHERE id = :id');
        $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
        return $stmt->execute();
    }

    public function getAllTodos($user_id) {
        $stmt = $this->db->prepare('SELECT * FROM todos WHERE user_id = :user_id');
        $stmt->bindValue(':user_id', $user_id, SQLITE3_INTEGER);
        return $stmt->execute();
    }

    public function addTodo($user_id, $task) {
        $stmt = $this->db->prepare('INSERT INTO todos (user_id, task) VALUES (:user_id, :task)');
        $stmt->bindValue(':user_id', $user_id, SQLITE3_INTEGER);
        $stmt->bindValue(':task', $task);
        return $stmt->execute();
    }
}
?>