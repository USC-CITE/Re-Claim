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
    <?php require __DIR__ . "/../mainpages/header.php"; ?>
    <main class="container">
        <article>
            <!-- Registration Form Heading -->
            <div>
                <img>
                <h2>Create Account  </h2>
                <p>Welcome to Re:Claim! Enter your 
                    information below to sign-up.</p>
            </div>


            <form method="POST" action="/register">
                <!-- temporary styling -->
                <div>
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
        </article>
    </main>
    

</body>
</html>
