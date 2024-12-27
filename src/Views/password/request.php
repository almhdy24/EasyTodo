<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Password Reset - EasyTodo</title>
    <link rel="stylesheet" href="/styles.css">
</head>
<body>
    <header>
        <h1>EasyTodo</h1>
    </header>
    <main class="auth-page">
        <section class="auth-form password-request-form">
            <h2>Request Password Reset</h2>
            <form action="/password/request" method="POST">
                <input type="email" name="email" placeholder="Email" required>
                <button type="submit">Request Reset</button>
            </form>
        </section>
    </main>
</body>
</html>