<?php
namespace EasyTodo\Models;

use EasyTodo\Config\Database;
use PDO;

class Task {
    private $id;
    private $title;
    private $description;
    private $completed;

    public function __construct($data = []) {
        $this->id = $data['id'] ?? null;
        $this->title = $data['title'] ?? '';
        $this->description = $data['description'] ?? '';
        $this->completed = $data['completed'] ?? 0;
    }

    public static function getAll() {
        $db = Database::init();
        $stmt = $db->query("SELECT * FROM tasks");
        $stmt->setFetchMode(PDO::FETCH_ASSOC); // Fetch as associative array
        $results = $stmt->fetchAll();
        
        // Map results to Task objects
        return array_map(function($data) {
            return new self($data);
        }, $results);
    }

    public function save() {
        $db = Database::init();
        $stmt = $db->prepare("INSERT INTO tasks (title, description, completed) VALUES (:title, :description, :completed)");
        $stmt->bindValue(':title', $this->title);
        $stmt->bindValue(':description', $this->description);
        $stmt->bindValue(':completed', $this->completed, PDO::PARAM_INT);
        $stmt->execute();
    }

    // Add getter methods
    public function getId() {
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getDescription() {
        return $this->description;
    }

    public function isCompleted() {
        return $this->completed;
    }
}