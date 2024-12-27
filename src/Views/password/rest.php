<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
</head>
<body>
    <h1>Reset Password</h1>
    <form action="/password/reset/confirm" method="POST">
        <label for="token">Token:</label>
        <input type="text" id="token" name="token" required>
        <br>
        <label for="password">New Password:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <button type="submit">Reset Password</button>
    </form>
</body>
</html>