<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - EasyTodo</title>
    <link rel="stylesheet" href="/styles.css">
</head>
<body>
    <header>
        <h1>EasyTodo</h1>
    </header>
    <main class="auth-page">
        <section class="auth-form">
            <h2>Login</h2>
            <form action="/login" method="POST">
                <input type="email" id="email" name="email" placeholder="Email" required>
                <input type="password" id="password" name="password" placeholder="Password" required>
                <button type="submit">Login</button>
            </form>
            <p>Don't have an account? <a href="/register">Register here</a></p>
            <p>Forgot your password? <a href="/password/request">Reset it here</a></p>
        </section>
    </main>
</body>
</html>