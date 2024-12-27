<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Task - EasyTodo</title>
    <link rel="stylesheet" href="/styles.css">
</head>
<body>
    <header>
        <h1>EasyTodo</h1>
    </header>
    <main class="create-task-page">
        <section class="create-task-form">
            <h2>Create Task</h2>
            <form action="/tasks/create" method="POST">
                <input type="text" id="title" name="title" placeholder="Title" required>
                <textarea id="description" name="description" placeholder="Description" required></textarea>
                <button type="submit">Create Task</button>
            </form>
        </section>
    </main>
</body>
</html>