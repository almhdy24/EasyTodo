<?php
session_start();

$db = new SQLite3('todos.db');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    $stmt = $db->prepare('INSERT INTO users (username, password) VALUES (:username, :password)');
    $stmt->bindValue(':username', $username);
    $stmt->bindValue(':password', $password);
    
    if ($stmt->execute()) {
        echo "User registered successfully!";
    } else {
        echo "Error: Username already exists!";
    }
}
?>
<form method="post">
    Username: <input type="text" name="username" required>
    Password: <input type="password" name="password" required>
    <input type="submit" value="Register">
</form>