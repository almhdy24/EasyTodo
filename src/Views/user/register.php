<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - EasyTodo</title>
    <link rel="stylesheet" href="/styles.css">
</head>
<body>
    <header>
        <h1>EasyTodo</h1>
    </header>
    <main class="register-page">
        <section class="register-form">
            <h2>Register</h2>
            <form action="/register" method="POST">
                <input type="text" id="name" name="name" placeholder="Name" required>
                <input type="email" id="email" name="email" placeholder="Email" required>
                <input type="password" id="password" name="password" placeholder="Password" required>
                <button type="submit">Register</button>
            </form>
            <div class="links">
                <a href="/login">Login</a>
            </div>
        </section>
    </main>
</body>
</html>