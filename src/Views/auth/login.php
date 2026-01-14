<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Example Login</title>
</head>
<body>

<h2>Login</h2>

<form method="POST" action="/login">
    <label>
        Email:
        <input type="email" name="email" required>
    </label>
    <br><br>

    <label>
        Password:
        <input type="password" name="password" required>
    </label>
    <br><br>

    <button type="submit">Login</button>
</form>

</body>
</html>
