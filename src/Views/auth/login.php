<!--
    * Layer: View
    * Purpose: UI rendering and templates
    * Rules: No business logic or DB access
-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@latest/css/pico.min.css">
    <title>WVSU ReClaim</title>
</head>
<body>
<main class="container">
    <article>
        <h2>Login</h2>

        <form method="POST" action="/login">
            <label>
                Email:
                <input type="email" name="email" required placeholder="example@wvsu.edu.ph">
            </label>
            <br><br>

            <label>
                Password:
                <input type="password" name="password" required>
            </label>
            <br><br>

            <button type="submit">Login</button>
        </form>
    </article>

    
</main>




</body>
</html>
