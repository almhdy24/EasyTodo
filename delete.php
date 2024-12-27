<?php
session_start();
require 'db.php';

$db = new Database('todos.db');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$errorMessage = "";
$message = "";

// Check if 'id' parameter is present
if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

    if ($id === false) {
        $errorMessage = "Invalid ID parameter.";
    } else {
        if ($db->deleteTodoById($id)) {
            $message = "Todo item deleted successfully.";
        } else {
            $errorMessage = "Failed to delete the To-Do item.";
        }
    }
}

header("Location: todos.php?message=" . urlencode($message) . "&error=" . urlencode($errorMessage));
exit;
?>