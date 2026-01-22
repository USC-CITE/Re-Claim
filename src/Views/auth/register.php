<!--
    * Layer: View
    * Purpose: UI rendering and templates
    * Rules: No business logic or DB access
-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Temporary Register</title>
</head>
<body>

<h2>Register</h2>

<form method="POST" action="/register">
    <label>
        First Name:
        <input type="firstname" name="firstname" required placeholder="John">
    </label>
    <br><br>
    <label>
        Last Name:
        <input type="lastname" name="lastname" required placeholder="Doe">
    </label>
    <br><br>

    <label>
        Email:
        <input type="email" name="email" required placeholder="example@wvsu.edu.ph">
    </label>
    <br><br>

    <label>
        Password:
        <input type="password" name="password" required>
    </label>
    <label>
        Confirm Password:
        <input type="confirm-pass" name="confirm-pass" required>
    </label>
    <br><br>
    
    <label>
        Phone Number:
        <input type="phone-num" name="phone-num" required>
    </label>
    <br><br>

    <!-- TODO: Add social media link field -->

    <button type="submit">Register</button>
</form>

</body>
</html>
