<?php
namespace EasyTodo\Models;

use EasyTodo\Config\Database;
use PDO;

class Task
{
    private $id;
    private $title;
    private $description;
    private $completed;
    private $db;

    public function __construct($data = [])
    {
        $this->id = $data["id"] ?? null;
        $this->title = $data["title"] ?? "";
        $this->description = $data["description"] ?? "";
        $this->completed = $data["completed"] ?? 0;
        $this->db = Database::getConnection(); // Optional as it's not used in static methods
    }

    public static function getAll()
    {
        $db = Database::getConnection(); // Retrieve database connection
        $stmt = $db->query("SELECT * FROM tasks");
        $stmt->setFetchMode(PDO::FETCH_ASSOC); // Fetch as associative array
        $results = $stmt->fetchAll();

        // Map results to Task objects
        return array_map(function ($data) {
            return new self($data);
        }, $results);
    }

    public function save()
    {
        $stmt = $this->db->prepare(
            "INSERT INTO tasks (title, description, completed) VALUES (:title, :description, :completed)"
        );
        $stmt->bindValue(":title", $this->title);
        $stmt->bindValue(":description", $this->description);
        $stmt->bindValue(":completed", $this->completed, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM tasks WHERE id = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Add getter methods
    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function isCompleted()
    {
        return $this->completed;
    }
}