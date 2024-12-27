<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List - EasyTodo</title>
    <link rel="stylesheet" href="/styles.css">
</head>
<body>
    <header>
        <h1>EasyTodo</h1>
    </header>
    <main class="tasks-page">
        <section class="tasks-list">
            <h2>Todo List</h2>
            <a class="create-task" href="/tasks/create">Create New Task</a>
            <?php if (!empty($tasks) && is_array($tasks)): ?>
                <ul>
                    <?php foreach ($tasks as $task): ?>
                        <li class="task-item">
                            <strong><?php echo htmlspecialchars($task->getTitle()); ?></strong>
                            <p><?php echo htmlspecialchars($task->getDescription()); ?></p>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No tasks found.</p>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>