<?php
session_start();

if (!isset($_SESSION["user_id"])) {
  header("Location: login.php");
  exit();
}

require "db.php";

$db = new Database("todos.db");

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $task = htmlspecialchars($_POST["task"], ENT_QUOTES, 'UTF-8');
  $user_id = $_SESSION["user_id"];

  if (!empty($task)) {
    if ($db->addTodo($user_id, $task)) {
      $message = "Todo added successfully!";
    } else {
      $error = "Error adding todo.";
    }
  } else {
    $error = "Task cannot be empty.";
  }
}

$user_id = $_SESSION["user_id"];
$result = $db->getAllTodos($user_id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Todo List</title>
    <link rel="stylesheet" href="styles.css"> <!-- Optional: Link to an external CSS file -->
</head>
<body>
<h1>Your Todo List</h1>

<?php if (isset($message)): ?>
    <div class="success"><?php echo $message; ?></div>
<?php endif; ?>
<?php if (isset($error)): ?>
    <div class="error"><?php echo $error; ?></div>
<?php endif; ?>

<form method="post">
    <label for="task">Task:</label>
    <input type="text" name="task" id="task" required>
    <input type="submit" value="Add Todo">
</form>

<ul>
    <?php while ($todo = $result->fetchArray(SQLITE3_ASSOC)): ?>
        <li>
            <?php echo htmlspecialchars($todo["task"]); ?> 
            <a href="delete.php?id=<?php echo htmlspecialchars(
              $todo["id"]
            ); ?>">Delete</a>
        </li>
    <?php endwhile; ?>
</ul>

<a href="logout.php">Logout</a>
</body>
</html>