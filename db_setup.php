<?php
// db_setup.php
$db = new SQLite3('todos.db');

// Create users table
$db->exec("CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT NOT NULL UNIQUE,
    password TEXT NOT NULL
)");

// Create todos table
$db->exec("CREATE TABLE IF NOT EXISTS todos (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER,
    task TEXT NOT NULL,
    status INTEGER DEFAULT 0,
    FOREIGN KEY(user_id) REFERENCES users(id)
)");

// Close database connection
$db->close();
?>