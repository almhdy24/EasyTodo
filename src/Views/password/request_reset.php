<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Request Password Reset</title>
</head>
<body>
    <h1>Request Password Reset</h1>
    <form action="/password/reset" method="POST">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <br>
        <button type="submit">Request Reset</button>
    </form>
</body>
</html>