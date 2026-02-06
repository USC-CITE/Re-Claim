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
    <!-- temporary styling -->
    <div style="display: flex">
        <label>
            First Name:
            <input type="text" name="firstname" required placeholder="John">
        </label>
        <br><br>
        <label>
            Last Name:
            <input type="text" name="lastname" required placeholder="Doe">
        </label>
    </div>
    
    <br><br>

    <label>
        WVSU Email Address:
        <input type="email" name="email" required placeholder="example@wvsu.edu.ph">
    </label>
    <br><br>

    <label>
        Password:
        <input type="password" name="password" required>
    </label>

    <br></br>   
    <label>
        Confirm Password:
        <input type="password" name="confirm-pass" required>
    </label>
    <br><br>
    
    <label>
        Phone Number:
        <input type="text" name="phone-num" required>
    </label>
    <label>
        Social Media Link
        <input type="text" name="social-link" required>
    </label>
    <br><br>



    <button type="submit">Register</button>
    <p>Already have an account?<a href="/login"><strong>Log in</strong></a></p>
</form>

</body>
</html>
