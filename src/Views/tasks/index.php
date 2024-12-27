<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Todo List</title>
</head>
<body>
    <h1>Todo List</h1>
    <a href="/tasks/create">Create New Task</a>
    <?php if (!empty($tasks) && is_array($tasks)): ?>
        <ul>
            <?php foreach ($tasks as $task): ?>
                <li>
                    <strong><?php echo htmlspecialchars($task->getTitle()); ?></strong>
                    <p><?php echo htmlspecialchars($task->getDescription()); ?></p>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No tasks found.</p>
    <?php endif; ?>
</body>
</html>